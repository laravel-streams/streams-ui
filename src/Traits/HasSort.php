<?php

namespace Streams\Ui\Traits;

trait HasSort
{
    protected int | \Closure | null $sort = null;

    public function sort(int | \Closure | null $sort): static
    {
        $this->sort = $sort;

        return $this;
    }

    public function getSort(): int
    {
        return $this->evaluate($this->sort) ?? -1;
    }
}
