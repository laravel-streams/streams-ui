<?php

namespace Streams\Ui\Builders\Navigation\Concerns;

trait HasGroup
{
    protected string | \Closure | null $group = null;
    
    public function group(string | \Closure | null $group): static
    {
        $this->group = $group;

        return $this;
    }

    public function getGroup(): ?string
    {
        return $this->evaluate($this->group);
    }
}
