<?php

namespace Floaush\Bundle\CommonEntityClass\Entity;

use Doctrine\ORM\Mapping as ORM;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Gender\LabelTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\IdTrait;

/**
 * Class CommonGender
 * @package Floaush\Bundle\CommonEntityClass\Entity
 * @ORM\Entity()
 * @ORM\Table(name="gender")
 */
class CommonGender
{
    use
        IdTrait,
        LabelTrait
    ;

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->label;
    }
}
