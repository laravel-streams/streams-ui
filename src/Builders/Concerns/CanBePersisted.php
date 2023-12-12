<?php

namespace Streams\Ui\Builders\Concerns;

trait CanBePersisted
{
    protected bool $persist = false;

    public function persist(bool $condition = true): static
    {
        $this->persist = $condition;

        return $this;
    }

    public function shouldPersist(): bool
    {
        return $this->persist;
    }
}
