<?php

namespace Streams\Ui\Traits;

trait HasSize
{
    protected string | array | \Closure | null $size = null;

    public function size(string | array | \Closure | null $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getSize(): string | array | null
    {
        return $this->evaluate($this->size);
    }
}
