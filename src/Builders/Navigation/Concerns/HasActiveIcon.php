<?php

namespace Streams\Ui\Builders\Navigation\Concerns;

trait HasActiveIcon
{
    protected string | \Closure | null $activeIcon = null;

    public function activeIcon(string | \Closure | null $activeIcon): static
    {
        $this->activeIcon = $activeIcon;

        return $this;
    }

    public function getActiveIcon(): ?string
    {
        return $this->evaluate($this->activeIcon);
    }
}
