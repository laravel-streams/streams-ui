<?php

namespace Streams\Ui\Builders\Concerns;

trait CanBeDisabled
{
    protected bool|string|\Closure|null $disabled = null;

    public function disabled(bool|string|\Closure|null $disabled): static
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function isDisabled(): bool
    {
        return (bool) $this->evaluate($this->disabled);
    }
}
