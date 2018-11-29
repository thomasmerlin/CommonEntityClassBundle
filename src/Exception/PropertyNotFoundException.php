<?php

namespace Floaush\Bundle\CommonEntityClass\Exception;

/**
 * Class PropertyNotFoundException
 * @package Floaush\Bundle\CommonEntityClass\Exception
 */
class PropertyNotFoundException extends \Exception
{
    public static function generateExceptionMessage(
        string $propertyGiven,
        array $availaibleProperties,
        string $className
    ): string {
        $exceptionMessage = 'Property "' . $propertyGiven . '" doesn\'t exist in class "' . $className . '". ';
        $exceptionMessage .= ' Availaible properties are : [';

        foreach ($availaibleProperties as $index => $property) {
            $exceptionMessage .= '"' . $property . '"';

            if ($index < (count($availaibleProperties) - 1)) {
                $exceptionMessage .= ', ';
            }
        }

        $exceptionMessage .= '].';

        return $exceptionMessage;
    }
}
