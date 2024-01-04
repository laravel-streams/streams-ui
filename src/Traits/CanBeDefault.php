<?php

namespace Streams\Ui\Traits;

trait CanBeDefault
{
    protected bool $default = false;

    public function default(bool $condition = true): static
    {
        $this->default = $condition;

        return $this;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }
}
