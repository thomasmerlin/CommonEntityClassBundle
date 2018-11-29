<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait IdTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component
 */
trait IdTrait
{
    /**
     * @ORM\Column(
     *     name="id",
     *     type="integer",
     *     nullable=false,
     *     unique=true
     * )
     * @ORM\GeneratedValue()
     * @ORM\Id()
     *
     * @var integer
     */
    protected $id;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
