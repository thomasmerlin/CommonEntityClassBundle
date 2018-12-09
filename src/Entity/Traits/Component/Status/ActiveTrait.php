<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Status;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait ActiveTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Status
 */
trait ActiveTrait
{
    /**
     * @ORM\Column(
     *     name="active",
     *     type="boolean",
     *     nullable=false
     * )
     *
     * @var boolean
     */
    protected $active = false;

    /**
     * @return bool
     */
    public function isActive(): ?bool
    {
        return $this->active;
    }

    /**
     * @param bool $active
     *
     * @return self
     */
    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
}
