<?php

namespace Streams\Ui\Traits;

use Streams\Ui\Builders\Builder;

trait BelongsToParent
{
    protected ?Builder $parent = null;

    public function parent(Builder $parent): static
    {
        $this->parent = $parent;

        return $this;
    }

    public function getParent(): ?Builder
    {
        return $this->parent;
    }
}
