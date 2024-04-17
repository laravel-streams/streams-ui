<?php

namespace Streams\Ui\Actions\Traits;

trait HasStyle
{
    protected string | \Closure | null $style = 'button';

    public function style(string | \Closure | null $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getStyle(): string | null
    {
        return $this->evaluate($this->style);
    }
}
