<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity\Gender;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait LabelTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Identity\Gender
 */
trait LabelTrait
{
    /**
     * @ORM\Column(
     *     name="label",
     *     type="string",
     *     length=255,
     *     nullable=false,
     *     unique=false,
     * )
     *
     * @var string
     */
    protected $label;

    /**
     * @return string|null
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return self
     */
    public function setLabel(string $label): self
    {
        $this->label = $label;
        return $this;
    }
}
