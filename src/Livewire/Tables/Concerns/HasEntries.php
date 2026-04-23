<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Database\Query\Builder;

trait HasEntries
{
    protected array $entries = [];

    // @deprecated
    public function entries($entries): static
    {
        return $this->tableEntries($entries);
    }

    public function tableEntries($entries): static
    {
        $this->entries = $entries;

        return $this;
    }

    public function getTableEntries(string $table = 'default'): Collection|Paginator
    {
        if (isset($this->entries[$table])) {
            return $this->entries[$table];
        }

        $tableInstance = $this->getTable($table);
        $query = $this->getFilteredSortedQuery($table);

        if (! $tableInstance->isPaginated()) {
            return $query->get();
        }

        $this->entries[$table] = $this->paginateQuery($query, $table);

        // @todo this is tied to PinClicks Rank Tracking data
        // Need to flesh out proper callbacks and clean up.
        $tableInstance->fire('entries_loaded', [
            'livewire' => $this,
            'table' => $tableInstance,
        ]);

        return $this->entries[$table];
    }

    public function getFilteredSortedQuery(string $table = 'default'): Criteria|Builder
    {
        $query = $this->getFilteredQuery($table);

        // @todo @@ this 👇
        // $this->applyGroupingToTableQuery($query);

        $this->applySortingToTableQuery($query, $table);

        return $query;
    }

    public function getFilteredQuery(string $table = 'default'): Criteria|Builder
    {
        return $this->filterQuery($this->getTable($table)->getQuery(), $table);
    }

    public function filterQuery(Criteria|Builder $query, string $table = 'default'): Criteria|Builder
    {
        $tableInstance = $this->getTable($table);

        $this->applyFiltersToTableQuery($query, $table);
        $this->applySearchToTableQuery($query, $table);

        foreach ($tableInstance->getColumns() as $column) {

            // if ($column->isHidden()) {
            //     continue;
            // }

            // $column->applyRelationshipAggregates($query);

            // if ($this->getTable()->isGroupsOnly()) {
            //     continue;
            // }

            // $column->applyEagerLoading($query);
        }

        return $query;
    }
}
