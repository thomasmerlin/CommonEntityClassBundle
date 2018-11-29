<?php

namespace Floaush\Bundle\CommonEntityClass\Entity;

use Doctrine\ORM\Mapping as ORM;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\IdTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\IdentityTrait;

/**
 * Class CommonUser
 * @package Floaush\Bundle\CommonEntityClass\Entity
 * @ORM\Entity()
 */
class CommonUser
{
    use
        IdentityTrait,
        IdTrait
    ;
}
