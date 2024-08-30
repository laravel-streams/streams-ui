<?php

namespace Streams\Ui\Components\Tables\Concerns;

use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Database\Query\Builder;

trait HasEntries
{
    protected Collection | Paginator $entries;

    public function getTableEntries(): Collection | Paginator
    {
        if (isset($this->entries)) {
            return $this->entries;
        }

        $query = $this->getFilteredSortedQuery();

        if (!$this->getTable()->isPaginated()) {
            return $query->get();
        }

        $this->entries = $this->paginateQuery($query);

        // @todo this is tied to PinClicks Rank Tracking data
        // Need to flesh out proper callbacks and clean up.
        $this->getTable()->fire('entries_loaded', [
            'livewire' => $this,
            'table' => $this->getTable(),
        ]);

        return $this->entries;
    }

    public function getFilteredSortedQuery(): Criteria | Builder
    {
        $query = $this->getFilteredQuery();

        // @todo @@ this 👇
        // $this->applyGroupingToTableQuery($query);

        $this->applySortingToTableQuery($query);

        return $query;
    }

    public function getFilteredQuery(): Criteria | Builder
    {
        return $this->filterQuery($this->getTable()->getQuery());
    }

    public function filterQuery(Criteria | Builder $query): Criteria | Builder
    {
        $this->applyFiltersToTableQuery($query);
        $this->applySearchToTableQuery($query);

        foreach ($this->getTable()->getColumns() as $column) {
          
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
