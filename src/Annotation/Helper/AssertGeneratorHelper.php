<?php

namespace Floaush\Bundle\CommonEntityClass\Annotation\Helper;

use Doctrine\Common\Annotations\AnnotationReader;
use Floaush\Bundle\CommonEntityClass\Annotation\AssertGenerator;
use Floaush\Bundle\CommonEntityClass\Exception\NotExistingClassException;
use Floaush\Bundle\CommonEntityClass\Exception\NotValidArrayFormatException;
use Floaush\Bundle\CommonEntityClass\Exception\PropertyNotFoundException;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;

/**
 * Class AssertGeneratorHelper
 * @package Floaush\Bundle\CommonEntityClass\Annotation\Helper
 */
class AssertGeneratorHelper
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
     * @return null|AssertGenerator
     * @throws \ReflectionException
     */
    public function getMessageOverriderAnnotation($entity): ?AssertGenerator
    {
        $reflection = $this->getReflectionClassForClass($entity);
        return $this->annotationReader->getClassAnnotation(
            $reflection,
            AssertGenerator::class
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
     * Check if the array size exceed a fixed limit.
     * Throws an NotValidArrayFormatException error if that's the case.
     *
     * @param array $array
     *
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\NotValidArrayFormatException
     */
    public function checkArraySize(array $array): void
    {
        $fieldArraySize = count($array);

        if ($fieldArraySize > AssertGenerator::MAX_ARRAY_SIZE_ALLOWED) {
            throw new NotValidArrayFormatException(
                NotValidArrayFormatException::generateExceptionMessage(
                    $fieldArraySize,
                    AssertGenerator::MAX_ARRAY_SIZE_ALLOWED
                )
            );
        }
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
     * Generate (more reorganize) the constraint's parameters and returns them all in an associative array.
     *
     * @param array $parameters The option parameters for the constraint.
     *
     * @return array
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\NotValidArrayFormatException
     */
    public function generateConstraintParameters(array $parameters): array
    {
        $constraintParameters = [];

        foreach ($parameters as $constraintParameter) {
            $constraintParameterSize = count($constraintParameter);
            if ($constraintParameterSize > self::CONSTRAINT_PARAMETER_ARRAY_SIZE) {
                throw new NotValidArrayFormatException(
                    NotValidArrayFormatException::generateExceptionMessage(
                        $constraintParameterSize,
                        self::CONSTRAINT_PARAMETER_ARRAY_SIZE
                    )
                );
            }

            $key = $constraintParameter[0];
            $value = $constraintParameter[1];

            if (array_key_exists($key, $constraintParameters) === false) {
                $constraintParameters[$key] = $value;
            }
        }

       return $constraintParameters;
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
     * @param $constraintName
     *
     * @throws \InvalidArgumentException
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\NotExistingClassException
     */
    public function checkConstraintDefinition($constraintName)
    {
        /**
         * Check if the constraint given is a string or not.
         */
        if (!is_string($constraintName)) {
            throw new \InvalidArgumentException(
                'Expected string type, got ' . gettype($constraintName) . '.'
            );
        }

        $constraintClass = "Symfony\\Component\\Validator\\Constraints\\" . $constraintName;

        if (!class_exists($constraintClass)) {
            throw new NotExistingClassException(
                'Class "' . $constraintClass . '" does not exist.'
            );
        }
    }
}
