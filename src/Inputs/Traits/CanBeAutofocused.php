<?php

namespace Streams\Ui\Inputs\Traits;

trait CanBeAutofocused
{
    protected bool | \Closure $isAutofocused = false;

    public function autofocus(bool | \Closure $condition = true): static
    {
        $this->isAutofocused = $condition;

        return $this;
    }

    public function isAutofocused(): bool
    {
        return (bool) $this->evaluate($this->isAutofocused);
    }
}
