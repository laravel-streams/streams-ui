<?php

namespace Streams\Ui\Builders\Navigation\Concerns;

use Illuminate\Contracts\Support\Arrayable;

trait HasItems
{
    protected array | Arrayable $items = [];

    public function items(array | Arrayable $items): static
    {
        $this->items = [
            ...$this->items,
            ...$items,
        ];

        return $this;
    }

    public function getItems(): array | Arrayable
    {
        return $this->items;
    }
}
