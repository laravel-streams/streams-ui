<?php

namespace Streams\Ui\Inputs\Traits;

trait HasStep
{
    protected int | float | string | \Closure | null $step = null;

    public function step(int | float | string | \Closure | null $interval): static
    {
        $this->step = $interval;

        return $this;
    }

    public function getStep(): int | float | string | null
    {
        return $this->evaluate($this->step);
    }
}
