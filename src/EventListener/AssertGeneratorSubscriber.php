<?php

namespace Floaush\Bundle\CommonEntityClass\EventListener;

use Floaush\Bundle\CommonEntityClass\Annotation\Helper\AssertGeneratorHelper;
use Floaush\Bundle\CommonEntityClass\Exception\PropertyNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AssertGeneratorSubscriber
 * @package Floaush\Bundle\CommonEntityClass\EventListener
 */
class AssertGeneratorSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Floaush\Bundle\CommonEntityClass\Annotation\Helper\AssertGeneratorHelper $messageOverriderHelper
     */
    private $assertGeneratorHelper;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    private $validator;

    /**
     * MessageOverriderSubscriber constructor.
     *
     * @param \Floaush\Bundle\CommonEntityClass\Annotation\Helper\AssertGeneratorHelper $assertGeneratorHelper
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface                 $validator
     */
    public function __construct(
        AssertGeneratorHelper $assertGeneratorHelper,
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
            $constraint = $fieldArray[1];
            $constraintParameters = array_slice($fieldArray, 2);
            $className = get_class($entity);

            $classProperties = $this->assertGeneratorHelper->getClassProperties($className);

            /**
             * Check if the property defined in the annotation exists in the class.
             */
            if (!in_array($property, $classProperties)) {
                throw new PropertyNotFoundException(
                    PropertyNotFoundException::generateExceptionMessage(
                        $property,
                        $classProperties,
                        $className
                    )
                );
            }

            $getter = 'get' . ucfirst($property);
            $constraintParameters = $this->assertGeneratorHelper->generateConstraintParameters($constraintParameters);
            $constraintClass = "Symfony\\Component\\Validator\\Constraints\\" . $constraint;

            $violations = $this->validator->validate(
                $entity->$getter(),
                new $constraintClass($constraintParameters)
            );

            if (count($violations) > 0) {
                $formProperty = $form->get($property);
                if (array_key_exists('message', $constraintParameters) === true) {
                    $formProperty->addError(
                        new FormError($constraintParameters['message'])
                    );
                    continue;
                }

                $formProperty->addError(
                    new FormError((new $constraintClass())->message)
                );
            }
        }
    }
}