<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\State;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait ActiveTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\State
 */
trait ActiveTrait
{
    /**
     * @ORM\Column(
     *     name="active",
     *     type="boolean",
     *     nullable=false
     * )
     *
     * @var boolean
     */
    protected $active;
}