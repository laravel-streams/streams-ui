<?php

namespace Streams\Ui\Builders\Concerns;

trait CanBeDisabled
{
    protected bool $disabled = false;

    public function disabled(bool $condition = true): static
    {
        $this->disabled = $condition;

        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
