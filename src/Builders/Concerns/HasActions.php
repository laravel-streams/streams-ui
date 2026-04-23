<?php

namespace Streams\Ui\Builders\Concerns;

trait HasActions
{
    protected array $actions = [];

    public function actions(array $actions): static
    {
        $this->actions = array_filter([
            ...$this->actions,
            ...$actions,
        ]);

        return $this;
    }

    public function getActions(): array
    {
        return $this->evaluate($this->actions);
    }
}
