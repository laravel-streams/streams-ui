<?php

namespace Streams\Ui\Builders\Concerns;

trait HasSortOrder
{
    protected int|\Closure|null $sortOrder = null;

    public function sortOrder(int|\Closure|null $sortOrder): static
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function sort(int|\Closure|null $sort): static
    {
        return $this->sortOrder($sort);
    }

    public function getSortOrder(): int
    {
        return $this->evaluate($this->sortOrder) ?? -1;
    }
}
