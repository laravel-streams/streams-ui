<?php

namespace Streams\Ui\Traits;

trait CanBeDisabled
{
    protected bool | \Closure $disabled = false;

    public function disabled(bool | \Closure $condition = true): static
    {
        $this->disabled = $condition;

        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->evaluate($this->disabled);
    }
}
