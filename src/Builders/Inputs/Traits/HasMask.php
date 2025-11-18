<?php

namespace Streams\Ui\Builders\Inputs\Traits;

trait HasMask
{
    protected string|\Closure|null $mask = null;

    public function mask(string|\Closure|null $mask): static
    {
        $this->mask = $mask;

        return $this;
    }

    public function getMask(): ?string
    {
        return $this->evaluate($this->mask);
    }
}
