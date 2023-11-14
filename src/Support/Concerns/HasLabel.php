<?php

namespace Streams\Ui\Support\Concerns;

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
