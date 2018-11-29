<?php

namespace Floaush\Bundle\CommonEntityClass\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * Class AssertGenerator
 * @package Floaush\Bundle\CommonEntityClass\Annotation
 * @Annotation
 * @Target("CLASS")
 */
class AssertGenerator
{
    const MAX_ARRAY_SIZE_ALLOWED = 3;
    const INVALID_ARGUMENT_EXCEPTION_MESSAGE = "The annotation AssertGenerator must have an attribute 'fields'.";

    /**
     * @var array List of fields having their error message being overriden.
     */
    private $fields;

    /**
     * MessageOverrider constructor.
     *
     * @param array $options The options of this annotation.
     */
    public function __construct(array $options)
    {
        if (empty($options['fields']) === true) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT_EXCEPTION_MESSAGE);
        }

        $this->fields = $options['fields'];
    }

    /**
     * Returns the list of fields to be overriden.
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }
}
