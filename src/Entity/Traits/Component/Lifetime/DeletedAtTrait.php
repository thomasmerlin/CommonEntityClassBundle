<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Lifetime;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait DeletedAtTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Lifetime
 */
trait DeletedAtTrait
{
    /**
     * @ORM\Column(
     *     name="deletedAt",
     *     type="datetime",
     *     nullable=true,
     *     unique=false
     * )
     *
     * @var \DateTime
     */
    protected $deletedAt;

    /**
     * @return self
     */
    public function setDeletedAt(): self
    {
        $this->deletedAt = new \DateTime('now');
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getDeletedAt(): ?\DateTime
    {
        return $this->deletedAt;
    }
}
