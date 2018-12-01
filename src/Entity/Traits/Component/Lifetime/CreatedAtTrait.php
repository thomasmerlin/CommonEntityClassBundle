<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Lifetime;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait CreatedAtTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component
 * @ORM\HasLifecycleCallbacks()
 */
trait CreatedAtTrait
{
    /**
     * @ORM\Column(
     *     name="createdAt",
     *     type="datetime",
     *     nullable=false,
     *     unique=false
     * )
     *
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @ORM\PrePersist()
     *
     * @return self
     */
    public function setCreatedAt(): self
    {
        $this->createdAt = new \DateTime('now');
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }
}
