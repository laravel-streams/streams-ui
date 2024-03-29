<?php

namespace Streams\Ui\Inputs\Traits;

trait CanBeDisabled
{
    protected bool | \Closure | null $disabled = null;

    public function disabled(string | \Closure | null $disabled): static
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function isDisabled(): bool
    {
        return (bool) $this->evaluate($this->disabled);
    }
}
