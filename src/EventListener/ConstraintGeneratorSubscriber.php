<?php

namespace Floaush\Bundle\CommonEntityClass\EventListener;

use Floaush\Bundle\CommonEntityClass\Annotation\Helper\ConstraintGeneratorHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AssertGeneratorSubscriber
 * @package Floaush\Bundle\CommonEntityClass\EventListener
 */
class ConstraintGeneratorSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Floaush\Bundle\CommonEntityClass\Annotation\Helper\ConstraintGeneratorHelper $messageOverriderHelper
     */
    private $assertGeneratorHelper;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    private $validator;

    /**
     * MessageOverriderSubscriber constructor.
     *
     * @param \Floaush\Bundle\CommonEntityClass\Annotation\Helper\ConstraintGeneratorHelper $assertGeneratorHelper
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface                     $validator
     */
    public function __construct(
        ConstraintGeneratorHelper $assertGeneratorHelper,
        ValidatorInterface $validator
    ) {
        $this->assertGeneratorHelper = $assertGeneratorHelper;
        $this->validator = $validator;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'onPostSubmit'
        ];
    }

    /**
     * @param \Symfony\Component\Form\FormEvent $event
     *
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\NotExistingClassException
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\NotValidArrayFormatException
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\PropertyNotFoundException
     * @throws \ReflectionException
     */
    public function onPostSubmit(FormEvent $event)
    {
        $entity = $event->getData();
        $form = $event->getForm();

        $messageOverriderAnnotation = $this->assertGeneratorHelper->getMessageOverriderAnnotation($entity);

        if ($messageOverriderAnnotation === null) {
            return;
        }

        $overridableFields = $this->assertGeneratorHelper->getOverridableFields($entity);

        foreach ($overridableFields as $fieldArray) {
            $this->assertGeneratorHelper->checkArraySize($fieldArray);

            $property = $fieldArray[0];

            $constraintName = $fieldArray[1];
            $constraintParameters = $fieldArray[2];

            $className = get_class($entity);
            $classProperties = $this->assertGeneratorHelper->getClassProperties($className);

            $this->assertGeneratorHelper->checkPropertyDefinition(
                $property,
                $className,
                $classProperties
            );
            $this->assertGeneratorHelper->checkConstraintDefinition($constraintName);
            $this->assertGeneratorHelper->checkConstraintParametersDefinition($constraintParameters);

            $constraintClass = "Symfony\\Component\\Validator\\Constraints\\" . $constraintName;
            $fieldGetter = 'get' . ucfirst($property);

            /**
             * @var \Symfony\Component\Validator\ConstraintViolationList $violations
             */
            $violations = $this->validator->validate(
                $entity->$fieldGetter(),
                new $constraintClass($constraintParameters)
            );

            if (count($violations) > 0) {
                $formProperty = $form->get($property);
                /**
                 * @var \Symfony\Component\Validator\ConstraintViolation $violation
                 */
                foreach ($violations->getIterator()->getArrayCopy() as $violation) {
                    $formProperty->addError(
                        new FormError($violation->getMessage())
                    );
                }
            }
        }
    }
}
