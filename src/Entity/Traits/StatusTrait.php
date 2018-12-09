<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits;

use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Status\ActiveTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Status\EnabledTrait;

/**
 * Trait StatusTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits
 */
trait StatusTrait
{
    use
        ActiveTrait,
        EnabledTrait
    ;
}