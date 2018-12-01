<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits;

use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity\EmailTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity\FirstnameTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity\LastnameTrait;

/**
 * Trait IdentityTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits
 */
trait IdentityTrait
{
    use
        FirstnameTrait,
        LastnameTrait,
        EmailTrait
    ;
}
