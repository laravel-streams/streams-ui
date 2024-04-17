<?php

namespace Streams\Ui\Actions\Traits;

trait HasBorderRadius
{
    protected string | \Closure | bool | null $borderRadius = null;

    public function borderRadius(string | \Closure | bool | null $borderRadius): static
    {
        $this->borderRadius = $borderRadius;

        return $this;
    }

    public function getBorderRadius(): string | bool | null
    {
        return $this->evaluate($this->borderRadius);
    }
}
