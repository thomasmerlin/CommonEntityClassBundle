<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait PhoneNumberTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity
 */
trait PhoneNumberTrait
{
    /**
     * @ORM\Column(
     *     name="phoneNumber",
     *     type="string",
     *     length=15,
     *     nullable=true,
     *     unique=true
     * )
     *
     * @var string
     */
    protected $phoneNumber;

    /**
     * @return string|null
     */
    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return self
     */
    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }
}
