<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Associations\OneToOne;

use Doctrine\ORM\Mapping as ORM;
use Floaush\Bundle\CommonEntityClass\Entity\CommonGender;

/**
 * Trait OtOUserGenderTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Associations\OneToOne
 */
trait OtOUserGenderTrait
{
    /**
     * @var \Floaush\Bundle\CommonEntityClass\Entity\CommonGender $gender
     *
     * @ORM\OneToOne(targetEntity="Floaush\Bundle\CommonEntityClass\Entity\CommonGender")
     */
    protected $gender;

    /**
     * @return \Floaush\Bundle\CommonEntityClass\Entity\CommonGender
     */
    public function getGender(): ?CommonGender
    {
        return $this->gender;
    }

    /**
     * @param \Floaush\Bundle\CommonEntityClass\Entity\CommonGender $commonGender
     *
     * @return self
     */
    public function setGender(CommonGender $commonGender): self
    {
        $this->gender = $commonGender;

        return $this;
    }
}