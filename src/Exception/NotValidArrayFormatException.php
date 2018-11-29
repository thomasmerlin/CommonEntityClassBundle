<?php

namespace Floaush\Bundle\CommonEntityClass\Exception;

/**
 * Class NotValidArrayFormatException
 * @package Floaush\Bundle\CommonEntityClass\Exception
 */
class NotValidArrayFormatException extends \Exception
{
    /**
     * @param int $actualArraySize
     * @param int $expectedArraySize
     *
     * @return string
     */
    public static function generateExceptionMessage(
        int $actualArraySize,
        int $expectedArraySize
    ): string {
        return "The given array has " . $actualArraySize . " elements, expected " . $expectedArraySize . ".";
    }
}
