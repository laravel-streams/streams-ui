<?php

namespace Streams\Ui\Tables\Columns\Concerns;

trait IsSortable
{
    protected bool $sortable = false;

    protected ?array $sortColumns = [];

    protected ?string $initialSort = null;

    protected ?\Closure $sortQuery = null;

    public function sortable(
        bool | array $condition = true,
        ?\Closure $query = null
    ): static {

        if (is_array($condition)) {
            $this->sortable = true;
            $this->sortColumns = $condition;
        } else {
            $this->sortable = $condition;
            $this->sortColumns = null;
        }

        $this->sortQuery = $query;

        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }

    public function initialSort($direction)
    {
        $this->initialSort = $direction;

        return $this;
    }

    function getInitialSort(): string
    {
        return $this->initialSort ?: 'asc';
    }
}
