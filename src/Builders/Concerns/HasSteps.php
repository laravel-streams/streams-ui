<?php

namespace Streams\Ui\Builders\Concerns;

trait HasSteps
{
    protected array|\Closure $steps = [];

    public function steps(array|\Closure $steps): static
    {
        $this->steps = $steps;

        return $this;
    }

    public function getSteps(): array
    {
        return $this->evaluate($this->steps);
    }
}
