<?php

namespace Floaush\Bundle\CommonEntityClass\Entity\Traits;

use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Status\ActiveTrait;
use Floaush\Bundle\CommonEntityClass\Entity\Traits\Component\Status\EnabledTrait;

/**
 * Trait StatusTrait
 * @package Floaush\Bundle\CommonEntityClass\Entity\Traits
 */
trait StatusTrait
{
    /**
     * StatusTrait constructor.
     */
    public function __construct()
    {
        $this->active = false;
        $this->enabled = false;
    }

    use
        ActiveTrait,
        EnabledTrait
    ;
}