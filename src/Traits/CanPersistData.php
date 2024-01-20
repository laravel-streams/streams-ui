<?php

namespace Streams\Ui\Traits;

use Illuminate\Support\Arr;

trait CanPersistData
{
    protected bool $persist = false;

    public function persist(string $path, bool $condition = true): static
    {
        $this->persist[$path] = $condition;

        return $this;
    }

    public function shouldPersist($path): bool
    {
        return Arr::get($this->persist, $path, false);
    }
}
