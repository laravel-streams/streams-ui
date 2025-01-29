<?php

namespace Streams\Ui\Traits;

trait CanBeSorted
{
    protected bool | \Closure | null $sortable = null;

    public function sortable(string | \Closure | null $sortable): static
    {
        $this->sortable = $sortable;

        return $this;
    }

    public function isSortable(): string | null
    {
        return $this->evaluate($this->sortable);
    }
}
