<?php

namespace Streams\Ui\Navigation\Concerns;

trait HasIcon
{
    protected string | \Closure | null $icon = null;

    protected string | \Closure | null $activeIcon = null;

    public function icon(string | \Closure | null $icon): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function activeIcon(string | \Closure | null $activeIcon): static
    {
        $this->activeIcon = $activeIcon;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->evaluate($this->icon);
    }

    public function getActiveIcon(): ?string
    {
        return $this->evaluate($this->activeIcon);
    }
}
