<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait RolesTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits
 */
trait RolesTrait
{
    /**
     * @ORM\Column(
     *     name="roles",
     *     type="array",
     *     nullable=false
     * )
     *
     * @var array
     */
    protected $roles = ['ROLE_USER'];
}