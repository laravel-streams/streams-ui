<?php

namespace Streams\Ui\Traits;

trait HasColors
{
    protected string | array | \Closure | null $colors = null;

    public function colors(string | array | \Closure | null $colors): static
    {
        $this->colors = $colors;

        return $this;
    }

    public function getColors(): string | array | null
    {
        return $this->evaluate($this->colors);
    }
}
