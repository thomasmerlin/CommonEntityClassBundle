<?php

namespace Floaush\Bundle\CommonEntityClass\Annotation\Helper;

use Doctrine\Common\Annotations\AnnotationReader;
use Floaush\Bundle\CommonEntityClass\Annotation\AssertGenerator;
use Floaush\Bundle\CommonEntityClass\Exception\NotValidArrayFormatException;
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
     * @param $entity
     *
     * @return array
     * @throws \ReflectionException
     */
    public function getOverridableFields($entity)
    {
        $messageOverriderAnnotation = $this->getMessageOverriderAnnotation($entity);

        if ($messageOverriderAnnotation === null) {
            return [];
        }

        return $messageOverriderAnnotation->getFields();
    }

    /**
     * Check if the annotation (@see MessageOverrider) is present for the given entity.
     * Also return the annotation if @MessageOverrider annotation exists.
     *
     * @param $entity
     *
     * @return null|AssertGenerator
     * @throws \ReflectionException
     */
    public function getMessageOverriderAnnotation($entity)
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
     * @param $entity
     *
     * @return \ReflectionClass
     * @throws \ReflectionException
     */
    public function getReflectionClassForClass($entity)
    {
        return new \ReflectionClass(get_class($entity));
    }

    /**
     * @param string           $property
     * @param \ReflectionClass $reflectionClass
     *
     * @return \ReflectionProperty
     */
    public function getReflectionPropertyForClass(
        string $property,
        \ReflectionClass $reflectionClass
    ) {
        return $reflectionClass->getProperty($property);
    }

    /**
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

    public function getClassProperties($className)
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
     * @param array $parameters
     *
     * @return array
     * @throws \Floaush\Bundle\CommonEntityClass\Exception\NotValidArrayFormatException
     */
    public function generateConstraintParameters(array $parameters)
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
}