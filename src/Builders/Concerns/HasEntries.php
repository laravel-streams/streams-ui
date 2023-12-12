<?php

namespace Streams\Ui\Builders\Concerns;

use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;

trait HasEntries
{
    public Collection | Paginator $records;

    public function getTableEntries(): Collection | Paginator
    {
        $query = $this->getFilteredSortedQuery();

        if (!$this->isPaginated()) {
            return $this->records = $query->get();
        }

        return $this->records = $this->paginateQuery($query);
    }

    public function getFilteredSortedQuery(): Criteria
    {
        $query = $this->getFilteredQuery();

        //$this->applyGroupingToTableQuery($query);

        //$this->applySortingToTableQuery($query);

        return $query;
    }

    public function getFilteredQuery(): Criteria
    {
        return $this->filterQuery($this->getQuery());
    }

    public function filterQuery(Criteria $query): Criteria
    {
        /**
         * @todo move this into a streams > workflow for tables/forms/etc using callbacks.
         */
        //$this->applyFiltersToTableQuery($query);
        //$this->applySearchToTableQuery($query);

        foreach ($this->getColumns() as $column) {
          
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
