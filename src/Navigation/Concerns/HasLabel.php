<?php

namespace Streams\Ui\Navigation\Concerns;

trait HasLabel
{
    protected string | \Closure | null $label;

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
