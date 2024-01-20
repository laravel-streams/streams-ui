<?php

namespace Streams\Ui\Components\Tables\Concerns;

use Illuminate\Support\Arr;
use Streams\Core\Criteria\Criteria;

trait CanSearchEntries
{
    public array $tableColumnSearches = [];

    public $tableSearch = '';

    public function updatedTableSearch(): void
    {
        // if ($this->getTable()->persistsSearchInSession()) {
        //     session()->put(
        //         $this->getTableSearchSessionKey(),
        //         $this->tableSearch,
        //     );
        // }

        // if ($this->getTable()->shouldDeselectAllRecordsWhenFiltered()) {
        //     $this->deselectAllTableRecords();
        // }

        $this->resetPage();
    }

    public function updatedTableColumnSearches(
        $value = null,
        ?string $key = null
    ): void {
        if (blank($value) && filled($key)) {
            Arr::forget($this->tableColumnSearches, $key);
        }

        if ($this->getTable()->persistsColumnSearchesInSession()) {
            session()->put(
                $this->getTableColumnSearchesSessionKey(),
                $this->tableColumnSearches,
            );
        }

        if ($this->getTable()->shouldDeselectAllRecordsWhenFiltered()) {
            $this->deselectAllTableRecords();
        }

        $this->resetPage();
    }

    protected function applySearchToTableQuery(Criteria $query): Criteria
    {
        //$this->applyColumnSearchesToTableQuery($query);
        $this->applyGlobalSearchToTableQuery($query);

        return $query;
    }

    protected function applyColumnSearchesToTableQuery(Criteria $query): Criteria
    {
        foreach ($this->getTableColumnSearches() as $column => $search) {

            if (blank($search)) {
                continue;
            }

            $column = $this->getTable()->getColumn($column);

            if (!$column) {
                continue;
            }

            if ($column->isHidden()) {
                continue;
            }

            if (!$column->isIndividuallySearchable()) {
                continue;
            }

            foreach ($this->extractTableSearchWords($search) as $searchWord) {
                // $query->where(function (Criteria $query) use ($column, $searchWord) {
                //     $isFirst = true;


                // });

                $column->applySearchConstraint($query, $searchWord);
            }
        }

        return $query;
    }

    protected function extractTableSearchWords(string $search): array
    {
        return array_filter(
            str_getcsv(preg_replace('/\s+/', ' ', $search), ' '),
            fn ($word): bool => filled($word),
        );
    }

    protected function applyGlobalSearchToTableQuery(Criteria $query): Criteria
    {
        $search = $this->getTableSearch();

        if (blank($search)) {
            return $query;
        }

        foreach ($this->extractTableSearchWords($search) as $searchWord) {
            
            // $query->where(function (Criteria $query) use ($searchWord) {
            //     $isFirst = true;
            //     // foreach ...
            // });

            foreach ($this->getTable()->getColumns() as $k => $column) {

                // if ($column->isHidden()) {
                //     continue;
                // }

                // if (!$column->isGloballySearchable()) {
                //     continue;
                // }

                $column->applySearch(
                    $query,
                    $searchWord,
                    $k == 0 // $isFirst
                );
            }
        }

        return $query;
    }

    public function getTableSearch(): ?string
    {
        return filled($this->tableSearch) ? trim(strval($this->tableSearch)) : null;
    }

    public function hasTableSearch(): bool
    {
        return filled($this->tableSearch);
    }

    public function resetTableSearch(): void
    {
        $this->tableSearch = '';

        $this->updatedTableSearch();
    }

    public function resetTableColumnSearch(string $column): void
    {
        $this->updatedTableColumnSearches(null, $column);
    }

    public function resetTableColumnSearches(): void
    {
        $this->tableColumnSearches = [];

        $this->updatedTableColumnSearches();
    }

    // public function getTableSearchIndicator(): Indicator
    // {
    //     return Indicator::make(__('filament-tables::table.fields.search.indicator') . ': ' . $this->getTableSearch())
    //         ->removeLivewireClickHandler('resetTableSearch');
    // }

    public function getTableColumnSearchIndicators(): array
    {
        $indicators = [];

        foreach ($this->getTable()->getColumns() as $column) {
            if ($column->isHidden()) {
                continue;
            }

            if (!$column->isIndividuallySearchable()) {
                continue;
            }

            $columnName = $column->getName();

            $search = Arr::get($this->tableColumnSearches, $columnName);

            if (blank($search)) {
                continue;
            }

            // $indicators[] = Indicator::make("{$column->getLabel()}: {$search}")
            //     ->removeLivewireClickHandler("resetTableColumnSearch('{$columnName}')");
        }

        return $indicators;
    }

    /**
     * @param  array<string, string | array<string, string | null> | null>  $searches
     * @return array<string, string | array<string, string | null> | null>
     */
    protected function castTableColumnSearches(array $searches): array
    {
        return array_map(
            fn ($search): array | string => is_array($search) ?
                $this->castTableColumnSearches($search) :
                strval($search),
            $searches,
        );
    }

    /**
     * @return array<string, string | null>
     */
    public function getTableColumnSearches(): array
    {
        // Example input of `$this->tableColumnSearches`:
        // [
        //     'number' => '12345 ',
        //     'customer' => [
        //         'name' => ' john Smith',
        //     ],
        // ]

        // The `$this->tableColumnSearches` array is potentially nested.
        // So, we iterate through it deeply:
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($this->tableColumnSearches),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $searches = [];
        $path = [];

        foreach ($iterator as $key => $value) {

            $path[$iterator->getDepth()] = $key;

            if (is_array($value)) {
                continue;
            }

            $searches[implode('.', array_slice($path, 0, $iterator->getDepth() + 1))] = trim(strval($value));
        }

        return $searches;

        // Example output:
        // [
        //     'number' => '12345',
        //     'customer.name' => 'john smith',
        // ]
    }

    public function getTableSearchSessionKey(): string
    {
        $table = class_basename($this::class);

        return "tables.{$table}_search";
    }

    public function getTableColumnSearchesSessionKey(): string
    {
        $table = class_basename($this::class);

        return "tables.{$table}_search_columns";
    }
}
