<?php

namespace Streams\Ui\Traits;

trait HasIconPosition
{
    protected string | array | \Closure | null $iconPosition = null;

    public function iconPosition(string | array | \Closure | null $iconPosition): static
    {
        $this->iconPosition = $iconPosition;

        return $this;
    }

    public function getIconPosition(): string | array | null
    {
        return $this->evaluate($this->iconPosition);
    }
}
