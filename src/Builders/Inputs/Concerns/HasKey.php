<?php

namespace Streams\Ui\Builders\Inputs\Concerns;

trait HasKey
{
    protected string | \Closure | null $key = null;

    public function key(string | \Closure | null $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function getKey(): ?string
    {
        return $this->evaluate($this->key);
    }
}