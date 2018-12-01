<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait UpdatedAtTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component
 * @ORM\HasLifecycleCallbacks()
 */
trait UpdatedAtTrait
{
    /**
     * @ORM\Column(
     *     name="updatedAt",
     *     type="datetime",
     *     nullable=false,
     *     unique=false
     * )
     *
     * @var \DateTime
     */
    protected $updatedAt;

    /**
     * @ORM\PreUpdate()
     *
     * @return self
     */
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new \DateTime('now');
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }
}
