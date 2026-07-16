<?php

namespace Streams\Ui\Builders\Concerns;

trait HasSpacing
{
    protected string|\Closure|null $spacing = 'sm';

    public function spacing(string|\Closure|null $spacing): static
    {
        $this->spacing = $spacing;

        return $this;
    }

    public function getSpacing(): ?string
    {
        return $this->evaluate($this->spacing);
    }
}
