<?php

namespace Streams\Ui\Builders\Inputs\Concerns;

trait HasSuffix
{
    protected string|\Closure|null $suffix = null;

    public function suffix(string|\Closure|null $suffix): static
    {
        $this->suffix = $suffix;

        return $this;
    }

    public function getSuffix(): ?string
    {
        return $this->evaluate($this->suffix);
    }
}
