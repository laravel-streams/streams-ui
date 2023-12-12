<?php

namespace Streams\Ui\Builders\Concerns;

trait HasLabel
{
    protected string | \Closure | null $label = null;

    public function label(string | \Closure | null $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getLabel(): string | null
    {
        return $this->evaluate($this->label);
    }
}
