<?php

namespace Streams\Ui\Tables\Concerns;

use Illuminate\Support\Arr;
use Streams\Ui\Tables\Columns\Column;

trait HasColumns
{
    protected array $columns = [];

    public function columns(array $columns): static
    {
        $this->columns = [
            ...$this->columns,
            ...$columns,
        ];

        return $this;
    }

    public function getColumns(): array
    {
        return $this->columns;
    }

    public function getColumn(string $name): ?Column
    {
        return Arr::first(
            $this->getColumns(),
            fn (Column $column) => $column->getName() === $name
        );
    }
}
