<?php

namespace Streams\Ui\Navigation\Concerns;

trait HasActive
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
