<?php

namespace Streams\Ui\Navigation\Traits;

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
