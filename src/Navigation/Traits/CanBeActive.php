<?php

namespace Streams\Ui\Navigation\Traits;

trait CanBeActive
{
    protected ?\Closure $active = null;

    public function isActiveWhen(\Closure $callback): static
    {
        $this->active = $callback;

        return $this;
    }

    public function isActive(): bool
    {
        $callback = $this->active;

        if ($callback === null) {
            return url($this->getUrl()) === request()->url();
        }

        return (bool) $this->evaluate($callback);
    }
}
