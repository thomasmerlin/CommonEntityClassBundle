<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait LastnameTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component
 */
trait LastnameTrait
{
    /**
     * @ORM\Column(
     *     name="lastname",
     *     type="string",
     *     length=255,
     *     nullable=false,
     *     unique=false
     * )
     *
     * @var string
     */
    protected $lastname;

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     *
     * @return self
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;
        return $this;
    }
}
