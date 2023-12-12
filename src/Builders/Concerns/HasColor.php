<?php

namespace Streams\Ui\Builders\Concerns;

trait HasColor
{
    protected string | array | \Closure | null $color = null;

    public function color(string | array | \Closure | null $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getColor(): string | array | null
    {
        return $this->evaluate($this->color);
    }
}
