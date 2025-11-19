<?php

namespace Streams\Ui\Builders\Actions\Concerns;

trait HasStyle
{
    protected string|\Closure|null $style = 'button';

    public function style(string|\Closure|null $style): static
    {
        $this->style = $style;

        return $this;
    }

    public function getStyle(): ?string
    {
        return $this->evaluate($this->style);
    }
}
