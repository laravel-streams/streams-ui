<?php

namespace Streams\Ui\Builders\Concerns;

trait HasVisibility
{
    protected bool | \Closure $hidden = false;

    public function hidden(bool | \Closure $condition = true): static
    {
        $this->hidden = $condition;

        return $this;
    }
    
    public function isVisible(): bool
    {
        return !$this->isHidden();
    }

    public function isHidden(): bool
    {
        return $this->evaluate($this->hidden);
    }
}
