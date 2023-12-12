<?php

namespace Streams\Ui\Builders\Navigation\Concerns;

trait CanBeCollapsed
{
    protected bool | \Closure $collapsed = false;

    protected bool | \Closure | null $collapsible = null;

    public function collapsed(bool | \Closure $condition = true): static
    {
        $this->collapsed = $condition;

        $this->collapsible($condition);

        return $this;
    }

    public function collapsible(bool | \Closure | null $condition = true): static
    {
        $this->collapsible = $condition;

        return $this;
    }

    public function isCollapsed(): bool
    {
        return (bool) $this->evaluate($this->collapsed);
    }

    public function isCollapsible(): bool
    {
        return (bool) ($this->evaluate($this->collapsible) ?? true);
    }
}
