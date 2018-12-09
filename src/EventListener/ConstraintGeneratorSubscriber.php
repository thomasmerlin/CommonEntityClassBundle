<?php

namespace Floaush\Bundle\CommonEntityClass\EventListener;

use Floaush\Bundle\CommonEntityClass\Annotation\Helper\ConstraintGeneratorHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AssertGeneratorSubscriber
 * @package Floaush\Bundle\CommonEntityClass\EventListener
 */
class ConstraintGeneratorSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Floaush\Bundle\CommonEntityClass\Annotation\Helper\ConstraintGeneratorHelper $constraintGeneratorHelper
     */
    private $constraintGeneratorHelper;

    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator
     */
    private $validator;

    /**
     * MessageOverriderSubscriber constructor.
     *
     * @param \Floaush\Bundle\CommonEntityClass\Annotation\Helper\ConstraintGeneratorHelper $constraintGeneratorHelper
     * @param \Symfony\Component\Validator\Validator\ValidatorInterface                     $validator
     */
    public function __construct(
        ConstraintGeneratorHelper $constraintGeneratorHelper,
        ValidatorInterface $validator
    ) {
        $this->constraintGeneratorHelper = $constraintGeneratorHelper;
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
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\PropertyNotFoundException
     * @throws \ReflectionException
     */
    public function onPostSubmit(FormEvent $event)
    {
        $entity = $event->getData();
        $form = $event->getForm();

        $constraintGeneratorAnnotation = $this->constraintGeneratorHelper->getMessageOverriderAnnotation($entity);

        if ($constraintGeneratorAnnotation === null) {
            return;
        }

        $overridableFields = $this->constraintGeneratorHelper->getOverridableFields($entity);

        $className = get_class($entity);
        $classProperties = $this->constraintGeneratorHelper->getClassProperties($className);

        foreach ($overridableFields as $property => $constraints) {
            $this->constraintGeneratorHelper->checkPropertyDefinition(
                $property,
                $className,
                $classProperties
            );

            foreach ($constraints as $constraint => $parameters) {
                $this->handleConstraintForProperty(
                    $form,
                    $entity,
                    $property,
                    $constraint,
                    $parameters
                );
            }
        }
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $form
     * @param mixed                                 $entity
     * @param string                                $property
     * @param string                                $constraint
     * @param array                                 $parameters
     *
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\NotExistingClassException
     */
    public function handleConstraintForProperty(
        FormInterface $form,
        $entity,
        string $property,
        string $constraint,
        array $parameters
    ) {
        $constraintClass = "Symfony\\Component\\Validator\\Constraints\\" . $constraint;

        $this->constraintGeneratorHelper->checkConstraintDefinition($constraintClass);
        $this->constraintGeneratorHelper->checkConstraintParametersDefinition(
            $constraintClass,
            $parameters
        );

        $fieldGetter = 'get' . ucfirst($property);

        /**
         * @var \Symfony\Component\Validator\ConstraintViolationList $violations
         */
        $violations = $this->validator->validate(
            $entity->$fieldGetter(),
            new $constraintClass($parameters)
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
