<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits;

use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Lifetime\CreatedAtTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Lifetime\DeletedAtTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Lifetime\UpdatedAtTrait;

/**
 * Trait LifeTimeTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits
 */
trait LifeTimeTrait
{
    use
        CreatedAtTrait,
        UpdatedAtTrait,
        DeletedAtTrait
    ;
}