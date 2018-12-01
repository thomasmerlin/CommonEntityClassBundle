<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait FirstnameTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component
 */
trait FirstnameTrait
{
    /**
     * @ORM\Column(
     *     name="firstname",
     *     type="string",
     *     length=255,
     *     nullable=false,
     *     unique=false
     * )
     *
     * @var string
     */
    protected $firstname;

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return self
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;
        return $this;
    }
}
