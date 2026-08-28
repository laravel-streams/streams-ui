<?php

namespace Streams\Ui\Livewire\Tables;

use Livewire\WithPagination;
use Streams\Ui\Builders\Tables\Table;
use Streams\Ui\Support\Facades\Tables;
use Streams\Core\Support\Traits\FiresCallbacks;

trait InteractsWithTables
{
    use Concerns\CanPaginateEntries;
    use Concerns\CanSearchEntries;
    use Concerns\CanSortEntries;
    use Concerns\HasActions;
    use Concerns\HasBulkActions;
    use Concerns\HasEntries;
    use Concerns\HasFilters;
    use Concerns\HasViews;
    use FiresCallbacks;
    use WithPagination {
        WithPagination::resetPage as resetLivewirePage;
    }

    protected array $cachedTables = [];

    public function bootedInteractsWithTables(): void
    {
        $this->cacheTables();
        $this->initializeTableState();
    }

    protected function initializeTableState(): void
    {
        foreach ($this->getCachedTables() as $name => $table) {
            $this->initializeSingleTableState($table);
        }
    }

    protected function initializeSingleTableState(Table $table): void
    {
        $filters = $table->getFiltersState();

        foreach ($table->getFilters() as $filter) {
            if (! isset($filters[$filter->getName()])) {
                $filters[$filter->getName()] = ['value' => null];
            }
        }

        $table->setState('filters', $filters);
        $activeView = $table->getState('active_view');
        $defaultView = $table->getDefaultView();
        $table->setState(
            'active_view',
            $activeView
                ?? ($defaultView && $table->getTableView($defaultView) ? $defaultView : null),
        );
        $table->setState('search', strval($table->getState('search', '')));
        $table->setState('records_per_page', $table->getState('records_per_page', $table->getPerPage()));
        $table->setState('selected', $table->getState('selected', []));
        $table->setState('select_all_matching', (bool) $table->getState('select_all_matching', false));
        $table->setState('mounted_bulk_action', $table->getState('mounted_bulk_action'));
        $table->setState('mounted_bulk_action_data', $table->getState('mounted_bulk_action_data', []));
        $table->setState('mounted_actions', $table->getState('mounted_actions', []));
        $table->setState('mounted_actions_data', $table->getState('mounted_actions_data', []));
        $table->setState('mounted_action_record', $table->getState('mounted_action_record'));
    }

    public function cacheTables(): array
    {
        $this->cachedTables = [];

        $registered = Tables::all();
        $tables = $this->getTables();

        foreach ($tables + $registered as $key => $table) {

            if ($table instanceof \Closure) {
                $table = $table();
            }

            if (! $table instanceof Table) {
                continue;
            }

            $name = is_string($key) ? $key : $table->getName();

            $table->name($name);
            $table->queryStringIdentifier($name);
            $table->livewire($this);

            $this->cachedTables[$name] = $this->table($table);

            $this->initializeSingleTableState($this->cachedTables[$name]);
        }

        if (! isset($this->cachedTables['default'])) {
            $this->cachedTables['default'] = $this->table($this->makeTable('default'));
        }

        return $this->cachedTables;
    }

    /**
     * @return array<string, Table|\Closure>
     */
    protected function getTables(): array
    {
        return [];
    }

    public function getCachedTables(): array
    {
        if ($this->cachedTables === []) {
            $this->cacheTables();
        }

        return $this->cachedTables;
    }

    protected function makeTable(string $name = 'default'): Table
    {
        return Table::make($this, $name);
    }

    public function getTable(string $name = 'default'): Table
    {
        $tables = $this->getCachedTables();

        if (! isset($tables[$name])) {

            $resolved = Tables::resolve($name);

            if (! $resolved instanceof Table) {
                throw new \InvalidArgumentException("No table named [{$name}] found in [".static::class.'].');
            }

            $resolved->name($name);
            $resolved->queryStringIdentifier($name);
            $resolved->livewire($this);

            $this->cachedTables[$name] = $this->table($resolved);
            $this->initializeSingleTableState($this->cachedTables[$name]);
        }

        return $this->cachedTables[$name];
    }

    public function table(Table $table): Table
    {
        return $table;
    }

    public function getQueryStringPropertyName(string $property, string $table = 'default'): string
    {
        if (filled($identifier = $this->getTable($table)->getQueryStringIdentifier())) {
            return $identifier.ucfirst($property);
        }

        return $property;
    }

    public function resetPage($pageName = null, string $table = 'default'): void
    {
        $this->resetLivewirePage($pageName ?? $this->getTablePaginationPageName($table));
    }
}
