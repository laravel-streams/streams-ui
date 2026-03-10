<?php

namespace Streams\Ui\Builders\Concerns;

trait CanBeActive
{
    protected bool|\Closure $active = false;

    public function active(bool|\Closure $condition = true): static
    {
        $this->active = $condition;

        return $this;
    }

    public function isActive(): bool
    {
        return (bool) $this->evaluate($this->active);
    }
}
