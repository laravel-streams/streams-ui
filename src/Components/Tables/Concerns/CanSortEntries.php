<?php

namespace Streams\Ui\Components\Tables\Concerns;

use Livewire\Attributes\Url;
use Streams\Core\Criteria\Criteria;

trait CanSortEntries
{
    #[Url(history: true)]
    public ?string $tableSortColumn = null;

    #[Url(history: true)]
    public ?string $tableSortDirection = null;

    public function sortTable(?string $column = null, ?string $direction = null): void
    {
        $initial = $this->table->getColumn($column)?->getInitialSort() ?: 'asc';

        $sequence = $initial == 'asc' ? ['asc', 'desc'] : ['desc', 'asc'];

        if ($column === $this->tableSortColumn) {
            $direction ??= match ($this->tableSortDirection) {
                $sequence[0] => $sequence[1],
                $sequence[1] => null,
                default => $sequence[0],
            };
        } else {
            $direction ??= $sequence[0];
        }

        $this->tableSortColumn = $direction ? $column : null;
        $this->tableSortDirection = $direction;

        $this->updatedTableSortColumn();
    }

    public function getTableSortColumn(): ?string
    {
        return $this->tableSortColumn;
    }

    public function getTableSortDirection(): ?string
    {
        return $this->tableSortDirection;
    }

    public function updatedTableSortColumn(): void
    {
        // if ($this->getTable()->persistsSortInSession()) {
        //     session()->put(
        //         $this->getTableSortSessionKey(),
        //         [
        //             'column' => $this->tableSortColumn,
        //             'direction' => $this->tableSortDirection,
        //         ],
        //     );
        // }

        // $this->resetPage();
    }

    public function updatedTableSortDirection(): void
    {
        // if ($this->getTable()->persistsSortInSession()) {
        //     session()->put(
        //         $this->getTableSortSessionKey(),
        //         [
        //             'column' => $this->tableSortColumn,
        //             'direction' => $this->tableSortDirection,
        //         ],
        //     );
        // }

        // $this->resetPage();
    }

    protected function applySortingToTableQuery(Criteria $query): Criteria
    {
        // if ($this->getTable()->isGroupsOnly()) {
        //     return $query;
        // }

        // if ($this->isTableReordering()) {
        //     return $query->orderBy($this->getTable()->getReorderColumn());
        // }

        if (!$this->tableSortColumn) {
            return $this->applyDefaultSorting($query);
        }

        $column = $this->getTable()->getSortableColumn($this->tableSortColumn);

        if (!$column) {
            return $this->applyDefaultSorting($query);
        }

        $sortDirection = $this->tableSortDirection === 'desc' ? 'desc' : 'asc';

        $column->applySort($query, $sortDirection);

        return $query;
    }

    protected function applyDefaultSorting(Criteria $query): Criteria
    {
        $sortColumnName = $this->getTable()->getDefaultSortColumn();
        $sortDirection = ($this->getTable()->getDefaultSortDirection()
            ?? $this->tableSortDirection) === 'desc' ? 'desc' : 'asc';

        if (
            $sortColumnName &&
            ($sortColumn = $this->getTable()->getSortableVisibleColumn($sortColumnName))
        ) {
            $sortColumn->applySort($query, $sortDirection);

            return $query;
        }

        if ($sortColumnName) {
            return $query->orderBy($sortColumnName, $sortDirection);
        }

        if ($sortQueryUsing = $this->getTable()->getDefaultSortQuery()) {
            app()->call($sortQueryUsing, [
                'direction' => $sortDirection,
                'query' => $query,
            ]);

            return $query;
        }

        // return $query->orderBy($query->getModel()->getQualifiedKeyName());
        return $query;
    }

    public function getTableSortSessionKey(): string
    {
        $table = class_basename($this::class);

        return "tables.{$table}_sort";
    }
}
