<?php

namespace Floaush\Bundle\CommonEntityClass\Annotation\Helper;

use Doctrine\Common\Annotations\AnnotationReader;
use Floaush\Bundle\CommonEntityClass\Annotation\ConstraintGenerator;
use Floaush\Bundle\CommonEntityClass\Exception\NotExistingClassException;
use Floaush\Bundle\CommonEntityClass\Exception\NotValidArrayFormatException;
use Floaush\Bundle\CommonEntityClass\Exception\PropertyNotFoundException;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;

/**
 * Class ConstraintGeneratorHelper
 * @package Floaush\Bundle\CommonEntityClass\Annotation\Helper
 */
class ConstraintGeneratorHelper
{
    const CONSTRAINT_PARAMETER_ARRAY_SIZE = 2;

    /**
     * @var \Doctrine\Common\Annotations\AnnotationReader $annotationReader
     */
    private $annotationReader;

    /**
     * MessageOverriderHelper constructor.
     *
     * @param \Doctrine\Common\Annotations\AnnotationReader $reader
     */
    public function __construct(AnnotationReader $reader)
    {
        $this->annotationReader = $reader;
    }

    /**
     * Returns an associative array containing all the overridable fields.
     *
     * @param object $entity The current entity.
     *
     * @return array
     * @throws \ReflectionException
     */
    public function getOverridableFields($entity): array
    {
        $messageOverriderAnnotation = $this->getMessageOverriderAnnotation($entity);

        if ($messageOverriderAnnotation === null) {
            return [];
        }

        return $messageOverriderAnnotation->getFields();
    }

    /**
     * Check if the annotation (@see AssertGenerator class) is present for the given entity.
     * Also return the annotation if "AssertGenerator" annotation exists.
     *
     * @param object $entity The current entity.
     *
     * @return null|ConstraintGenerator
     * @throws \ReflectionException
     */
    public function getMessageOverriderAnnotation($entity): ?ConstraintGenerator
    {
        $reflection = $this->getReflectionClassForClass($entity);
        return $this->annotationReader->getClassAnnotation(
            $reflection,
            ConstraintGenerator::class
        );
    }

    /**
     * Create a (@see \ReflectionClass) instance for a given entity.
     *
     * @param object $entity The current entity.
     *
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    public function getReflectionClassForClass($entity): \ReflectionClass
    {
        return new \ReflectionClass(get_class($entity));
    }

    /**
     * List of the properties for a given class name, using the extractors and PropertyInfo.
     *
     * @param string $className The name of the class.
     *
     * @return mixed|null|string[]
     */
    public function getClassProperties(string $className)
    {
        // a full list of extractors is shown further below
        $reflectionExtractor = new ReflectionExtractor();

        // array of PropertyListExtractorInterface
        $listExtractors = array($reflectionExtractor);

        // array of PropertyTypeExtractorInterface
        $typeExtractors = array($reflectionExtractor);

        // array of PropertyAccessExtractorInterface
        $accessExtractors = array($reflectionExtractor);

        $propertyInfo = new PropertyInfoExtractor(
            $listExtractors,
            $typeExtractors,
            [],
            $accessExtractors
        );

        $properties = $propertyInfo->getProperties($className);

        return $properties;
    }

    /**
     * Do multiple checks on the property value given to assert that the property is correct.
     *
     * @param        $property
     * @param string $className
     * @param array  $classProperties
     *
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\PropertyNotFoundException
     */
    public function checkPropertyDefinition(
        $property,
        string $className,
        array $classProperties
    ) {
        /**
         * Check if the property given is a string or not.
         */
        if (!is_string($property)) {
            throw new \InvalidArgumentException(
                'Expected string type, got ' . gettype($property) . '.'
            );
        }

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
    }

    /**
     * Check the constraint given and asserts it is a well existing class
     *
     * @param string $constraintClass
     *
     * @throws \InvalidArgumentException
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\NotExistingClassException
     */
    public function checkConstraintDefinition(string $constraintClass)
    {
        if (!class_exists($constraintClass)) {
            throw new NotExistingClassException(
                'Class "' . $constraintClass . '" does not exist.'
            );
        }
    }

    /**
     * Check if the constraint parameters argument is an array.
     * Throws an error if that is not the case.
     *
     * @param string $constraintClass
     * @param array $constraintParameters
     *
     * @throws \InvalidArgumentException
     */
    public function checkConstraintParametersDefinition(
        string $constraintClass,
        array $constraintParameters
    ) {
        if (is_array($constraintParameters) === false) {
            throw new \InvalidArgumentException(
                'Expected "array" type, got "' . gettype($constraintParameters) . '" instead.'
            );
        }

        $constraintProperties = $this->getClassProperties($constraintClass);
        $uncommonProperties = array_diff(array_keys($constraintParameters), $constraintProperties);

        if (count($uncommonProperties) > 0) {
            throw new PropertyNotFoundException(
                PropertyNotFoundException::generateExceptionMessage(
                    $uncommonProperties,
                    $constraintProperties,
                    $constraintClass
                )
            );
        }
    }
}
