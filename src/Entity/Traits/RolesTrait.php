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

    /**
     * @param array $roles
     *
     * @return self
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
}