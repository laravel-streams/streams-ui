<?php

namespace Streams\Ui\Tables\Concerns;

use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;

trait HasEntries
{
    public Collection | Paginator $records;

    public function getTableEntries(): Collection | Paginator
    {
        $query = $this->getFilteredSortedTableQuery();

        if (!$this->isPaginated()) {
            return $this->records = $query->get();
        }

        return $this->records = $this->paginateTableQuery($query);
    }

    public function getFilteredSortedTableQuery(): Criteria
    {
        $query = $this->getFilteredTableQuery();

        //$this->applyGroupingToTableQuery($query);

        //$this->applySortingToTableQuery($query);

        return $query;
    }

    public function getFilteredTableQuery(): Criteria
    {
        return $this->filterTableQuery($this->getQuery());
    }

    public function filterTableQuery(Criteria $query): Criteria
    {
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
