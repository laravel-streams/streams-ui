<?php

namespace Streams\Ui\Panels\Traits;

trait CanBeSpa
{
    protected bool | \Closure $spa = false;

    public function spa(bool | \Closure $condition = true): static
    {
        $this->spa = $condition;

        return $this;
    }

    public function isSpa(): bool
    {
        return (bool) $this->evaluate($this->spa);
    }
}
