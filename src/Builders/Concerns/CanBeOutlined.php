<?php

namespace Streams\Ui\Builders\Concerns;

trait CanBeOutlined
{
    protected bool|\Closure|null $outlined = null;

    public function outlined(bool|\Closure|null $condition = true): static
    {
        $this->outlined = $condition;

        return $this;
    }

    public function isOutlined(): bool
    {
        return (bool) $this->evaluate($this->outlined);
    }
}
