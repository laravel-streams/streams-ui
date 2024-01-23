<?php

namespace Streams\Ui\Traits;

trait HasValue
{
    protected string | \Closure | null $value = null;

    public function value(string | \Closure | null $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getValue(): string | null
    {
        return $this->evaluate($this->value);
    }
}
