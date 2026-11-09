<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Streams\Core\Criteria\Criteria;
use Illuminate\Database\Query\Builder;

trait CanSortEntries
{
    public function sortTable(?string $column = null, ?string $direction = null, string $table = 'default'): void
    {
        $tableInstance = $this->getTable($table);
        $initial = $tableInstance->getColumn($column)?->getInitialSort() ?: 'asc';

        $sequence = $initial == 'asc' ? ['asc', 'desc'] : ['desc', 'asc'];

        if ($column === $tableInstance->getSortColumn()) {
            $direction ??= match ($tableInstance->getSortDirection()) {
                $sequence[0] => $sequence[1],
                $sequence[1] => null,
                default => $sequence[0],
            };
        } else {
            $direction ??= $sequence[0];
        }

        $tableInstance->setState('sort.column', $direction ? $column : null);
        $tableInstance->setState('sort.direction', $direction);
        $this->resetPage(table: $table);
    }

    public function getTableSortColumn(string $table = 'default'): ?string
    {
        return $this->getTable($table)->getSortColumn();
    }

    public function getTableSortDirection(string $table = 'default'): ?string
    {
        return $this->getTable($table)->getSortDirection();
    }

    protected function applySortingToTableQuery(Criteria|Builder $query, string $table = 'default'): Criteria|Builder
    {
        return $this->getTable($table)->applySortingToQuery($query);
    }
}
