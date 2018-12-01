<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait EmailTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity
 */
trait EmailTrait
{
    /**
     * @ORM\Column(
     *     name="email",
     *     type="string",
     *     length=255,
     *     nullable=false,
     *     unique=true
     * )
     *
     * @var string
     */
    protected $email;

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}
