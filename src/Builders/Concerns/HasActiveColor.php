<?php

namespace Streams\Ui\Builders\Concerns;

trait HasActiveColor
{
    protected string|\Closure|null $activeColor = 'primary';

    public function activeColor(string|\Closure|null $activeColor): static
    {
        $this->activeColor = $activeColor;

        return $this;
    }

    public function getActiveColor(): ?string
    {
        return $this->evaluate($this->activeColor) ?? 'primary';
    }
}
