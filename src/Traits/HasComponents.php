<?php

namespace Streams\Ui\Traits;

trait HasComponents
{
    protected array | \Closure $components = [];

    public function components(array | \Closure $components): static
    {
        $this->components = $components;

        return $this;
    }

    public function getComponents(): array
    {
        return $this->evaluate($this->components);
    }
}
