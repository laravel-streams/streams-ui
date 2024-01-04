<?php

namespace Streams\Ui\Components\Tables;

use Streams\Ui\Builders\Tables\Table;
use Streams\Core\Support\Traits\FiresCallbacks;

trait InteractsWithTable
{
    use FiresCallbacks;

    use Concerns\HasEntries;
    use Concerns\HasBulkActions;
    
    use Concerns\CanSearchEntries;
    use Concerns\CanPaginateEntries;
    
    protected Table $table;

    public function bootedInteractsWithTable(): void
    {
        $this->table = $this->table($this->makeTable($this));

        // $this->table = Action::configureUsing(
        //     Closure::fromCallable([$this, 'configureTableAction']),
        //     fn (): Table => BulkAction::configureUsing(
        //         Closure::fromCallable([$this, 'configureTableBulkAction']),
        //         fn (): Table => $this->table($this->makeTable()),
        //     ),
        // );

        // $this->cacheForm('toggleTableColumnForm', $this->getTableColumnToggleForm());

        // $this->cacheForm('tableFiltersForm', $this->getTableFiltersForm());

        // if (! $this->shouldMountInteractsWithTable) {
        //     return;
        // }

        // if (! count($this->toggledTableColumns ?? [])) {
        //     $this->getTableColumnToggleForm()->fill(session()->get(
        //         $this->getTableColumnToggleFormStateSessionKey(),
        //         $this->getDefaultTableColumnToggleState()
        //     ));
        // }

        // $shouldPersistFiltersInSession = $this->getTable()->persistsFiltersInSession();
        // $filtersSessionKey = $this->getTableFiltersSessionKey();

        // if (! count($this->tableFilters ?? [])) {
        //     $this->tableFilters = null;
        // }

        // if (($this->tableFilters === null) && $shouldPersistFiltersInSession && session()->has($filtersSessionKey)) {
        //     $this->tableFilters = [
        //         ...($this->tableFilters ?? []),
        //         ...(session()->get($filtersSessionKey) ?? []),
        //     ];
        // }

        // // https://github.com/filamentphp/filament/pull/7999
        // if ($this->tableFilters) {
        //     $this->normalizeTableFilterValuesFromQueryString($this->tableFilters);
        // }

        // $this->getTableFiltersForm()->fill($this->tableFilters);

        // if ($shouldPersistFiltersInSession) {
        //     session()->put(
        //         $filtersSessionKey,
        //         $this->tableFilters,
        //     );
        // }

        // if ($this->getTable()->isDefaultGroupSelectable()) {
        //     $this->tableGrouping = $this->getTable()->getDefaultGroup()->getId();
        // }

        // $shouldPersistSearchInSession = $this->getTable()->persistsSearchInSession();
        // $searchSessionKey = $this->getTableSearchSessionKey();

        // if (blank($this->tableSearch) && $shouldPersistSearchInSession && session()->has($searchSessionKey)) {
        //     $this->tableSearch = session()->get($searchSessionKey);
        // }

        // $this->tableSearch = strval($this->tableSearch);

        // if ($shouldPersistSearchInSession) {
        //     session()->put(
        //         $searchSessionKey,
        //         $this->tableSearch,
        //     );
        // }

        // $shouldPersistColumnSearchesInSession = $this->getTable()->persistsColumnSearchesInSession();
        // $columnSearchesSessionKey = $this->getTableColumnSearchesSessionKey();

        // if ((blank($this->tableColumnSearches) || ($this->tableColumnSearches === [])) && $shouldPersistColumnSearchesInSession && session()->has($columnSearchesSessionKey)) {
        //     $this->tableColumnSearches = session()->get($columnSearchesSessionKey) ?? [];
        // }

        // $this->tableColumnSearches = $this->castTableColumnSearches(
        //     $this->tableColumnSearches ?? [],
        // );

        // if ($shouldPersistColumnSearchesInSession) {
        //     session()->put(
        //         $columnSearchesSessionKey,
        //         $this->tableColumnSearches,
        //     );
        // }

        // $shouldPersistSortInSession = $this->getTable()->persistsSortInSession();
        // $sortSessionKey = $this->getTableSortSessionKey();

        // if (blank($this->tableSortColumn) && $shouldPersistSortInSession && session()->has($sortSessionKey)) {
        //     $sort = session()->get($sortSessionKey);

        //     $this->tableSortColumn = $sort['column'] ?? null;
        //     $this->tableSortDirection = $sort['direction'] ?? null;
        // }

        // if ($shouldPersistSortInSession) {
        //     session()->put(
        //         $sortSessionKey,
        //         [
        //             'column' => $this->tableSortColumn,
        //             'direction' => $this->tableSortDirection,
        //         ],
        //     );
        // }

        // if ($this->getTable()->isPaginated()) {
        //     $this->tableRecordsPerPage = $this->getDefaultTableRecordsPerPageSelectOption();
        // }
    }

    protected function makeTable(): Table
    {
        return Table::make($this);
    }

    public function getTable(): Table
    {
        return $this->table;
    }

    public function getQueryStringPropertyName(string $property): string
    {
        if (filled($identifier = $this->getTable()->getQueryStringIdentifier())) {
            return $identifier . ucfirst($property);
        }

        return $property;
    }
}
