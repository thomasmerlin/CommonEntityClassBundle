<?php

namespace Floaush\Bundle\CommonEntityClass\Exception;

/**
 * Class PropertyNotFoundException
 * @package Floaush\Bundle\CommonEntityClass\Exception
 */
class PropertyNotFoundException extends \Exception
{
    /**
     * @param        $propertiesGiven
     * @param array  $availaibleProperties
     * @param string $className
     *
     * @return string
     */
    public static function generateExceptionMessage(
        $propertiesGiven,
        array $availaibleProperties,
        string $className
    ): string {
        $exceptionMessage = 'Properties [';

        $exceptionMessage .= self::renderPropertiesGiven($propertiesGiven);

        $exceptionMessage .= '] do not exist in class "' . $className . '". ';
        $exceptionMessage .= ' Availaible properties are : [';

        foreach ($availaibleProperties as $index => $property) {
            $exceptionMessage .= '"' . $property . '"';

            if ($index <= (count($availaibleProperties) - 1)) {
                $exceptionMessage .= ', ';
            }
        }

        $exceptionMessage .= '].';

        return $exceptionMessage;
    }

    /**
     * @param $propertiesGiven
     *
     * @return string
     */
    protected static function renderPropertiesGiven($propertiesGiven)
    {
        if (is_string($propertiesGiven)) {
            return $propertiesGiven;
        }

        $properties = "";

        foreach ($propertiesGiven as $index => $property) {
            $properties .= '"' . $property . '"';

            if ($index <= (count($propertiesGiven) - 1)) {
                $properties .= ', ';
            }
        }

        return $properties;
    }
}
