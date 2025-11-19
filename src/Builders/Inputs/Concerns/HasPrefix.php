<?php

namespace Streams\Ui\Builders\Inputs\Concerns;

trait HasPrefix
{
    protected string|\Closure|null $prefix = null;

    public function prefix(string|\Closure|null $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getPrefix(): ?string
    {
        return $this->evaluate($this->prefix);
    }
}
