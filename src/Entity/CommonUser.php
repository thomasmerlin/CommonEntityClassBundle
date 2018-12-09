<?php

namespace Floaush\Bundle\CommonEntityClass\Entity;

use Doctrine\ORM\Mapping as ORM;
use Floaush\Bundle\CommonEntityClass\Entity\Associations\OneToOne\OtOUserGenderTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\IdTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\State\ActiveTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\IdentityTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\LifeTimeTrait;

/**
 * Class CommonUser
 * @package Floaush\Bundle\CommonEntityClass\Entity
 * @ORM\MappedSuperclass()
 */
class CommonUser
{
    use
        IdTrait,
        IdentityTrait,
        ActiveTrait,
        LifeTimeTrait
    ;

    use
        OtOUserGenderTrait
    ;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }
}
