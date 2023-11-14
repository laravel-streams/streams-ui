<?php

namespace Streams\Ui\Tables\Columns\Concerns;

trait IsSortable
{
    protected bool $sortable = false;

    protected ?array $sortColumns = [];

    protected ?\Closure $sortQuery = null;

    public function sortable(
        bool | array $condition = true,
        ?\Closure $query = null
    ): static {

        if (is_array($condition)) {
            $this->isSortable = true;
            $this->sortColumns = $condition;
        } else {
            $this->isSortable = $condition;
            $this->sortColumns = null;
        }

        $this->sortQuery = $query;

        return $this;
    }

    public function isSortable(): bool
    {
        return $this->sortable;
    }
}
