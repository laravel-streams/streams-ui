<?php

namespace Streams\Ui\Components\Tables\Concerns;

use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;

trait HasEntries
{
    public Collection | Paginator $records;

    public function getTableEntries(): Collection | Paginator
    {
        $query = $this->getFilteredSortedQuery();

        if (!$this->getTable()->isPaginated()) {
            return $query->get();
        }

        return $this->paginateQuery($query);
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
        return $this->filterQuery($this->getTable()->getQuery());
    }

    public function filterQuery(Criteria $query): Criteria
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

    protected function applyFiltersToTableQuery(Criteria $query): Criteria
    {
        // @todo fix me
        $data = [];// $this->getTableFiltersForm()->getRawState();

        foreach ($this->getTable()->getFilters() as $filter) {

            $state = $data[$filter->getName()] ?? [
                'value' => request($filter->getName() . '-filter'),
            ];

            if ($state['value'] ?? false) {
                $query = $filter->table($this)->apply($query, $state);
            }
        }

        return $query;
    }
}
