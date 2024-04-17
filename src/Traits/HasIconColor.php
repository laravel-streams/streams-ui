<?php

namespace Streams\Ui\Traits;

trait HasIconColor
{
    protected string | array | \Closure | null $iconColor = null;

    public function iconColor(string | array | \Closure | null $iconColor): static
    {
        $this->iconColor = $iconColor;

        return $this;
    }

    public function getIconColor(): string | array | null
    {
        return $this->evaluate($this->iconColor);
    }
}
