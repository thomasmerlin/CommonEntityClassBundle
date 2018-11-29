<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits;

use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\FirstnameTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\LastnameTrait;

/**
 * Trait IdentityTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits
 */
trait IdentityTrait
{
    use
        FirstnameTrait,
        LastnameTrait
    ;
}
