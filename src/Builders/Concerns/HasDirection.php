<?php

namespace Streams\Ui\Builders\Concerns;

trait HasDirection
{
    protected string|\Closure|null $direction = 'col';

    public function direction(string|\Closure|null $direction): static
    {
        $this->direction = $direction;

        return $this;
    }

    public function getDirection(): string
    {
        $direction = $this->evaluate($this->direction) ?? 'col';

        if (! in_array($direction, ['row', 'col'], true)) {
            throw new \InvalidArgumentException("Direction must be 'row' or 'col', [{$direction}] given.");
        }

        return $direction;
    }

    public function isColumnDirection(): bool
    {
        return $this->getDirection() === 'col';
    }
}
