<?php

namespace Streams\Ui\Traits;

trait HasWidth
{
    protected string | array | \Closure | null $width = null;

    public function width(string | array | \Closure | null $width): static
    {

        $this->width = $width;

        return $this;
    }

    public function getWidth(): null | string | array
    {
        return $this->evaluate($this->width);
    }
}
