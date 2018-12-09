<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Status;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait EnabledTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Status
 */
trait EnabledTrait
{
    /**
     * @ORM\Column(
     *     name="enabled",
     *     type="boolean",
     *     nullable=false
     * )
     *
     * @var boolean
     */
    protected $enabled;

    /**
     * @return bool|null
     */
    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return self
     */
    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }
}
