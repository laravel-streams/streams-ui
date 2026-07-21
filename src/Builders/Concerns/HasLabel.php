<?php

namespace Streams\Ui\Builders\Concerns;

trait HasLabel
{
    protected string|\Closure|false|null $label = null;

    public function label(string|\Closure|false|null $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string|null|false
    {
        return $this->evaluate($this->label);
    }
}
