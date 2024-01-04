<?php

namespace Streams\Ui\Inputs\Traits;

trait CanBeHidden
{
    protected bool | \Closure | null $hidden = null;

    public function hidden(bool | \Closure | null $hidden = true): static
    {
        $this->hidden = $hidden;

        return $this;
    }

    public function isHidden(): bool
    {
        return (bool) $this->evaluate($this->hidden);
    }
}
