<?php

namespace Streams\Ui\Inputs\Traits;

trait HasMask
{
    protected string | \Closure | null $mask = null;

    public function mask(string | \Closure | null $mask): static
    {
        $this->mask = $mask;

        return $this;
    }

    public function getMask(): string | null
    {
        return $this->evaluate($this->mask);
    }
}
