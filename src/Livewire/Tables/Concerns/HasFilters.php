<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Streams\Core\Criteria\Criteria;
use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Builders\Tables\Filters\Filter;
use Streams\Ui\Builders\Forms\Components\Group;
use Illuminate\Contracts\Database\Query\Builder;

trait HasFilters
{
    public function getTableFiltersForm(string $table = 'default'): Form
    {
        return $this->once(__FUNCTION__.$table, function () use ($table) {
            $tableInstance = $this->getTable($table);

            return $this->makeForm()
                ->schema($this->getTableFiltersFormSchema($table))
                ->columns($tableInstance->getFiltersFormColumns())
                ->model($tableInstance->getModel())
                ->statePath($tableInstance->getStatePath().'.filters')
                ->live();
        });
    }

    public function updatedTableFilters(string $table = 'default'): void
    {
        $this->resetPage(table: $table);
    }

    public function removeTableFilter(
        string $filterName,
        ?string $field = null,
        bool $shouldTriggerUpdatedFiltersHook = true,
        string $table = 'default'
    ): void {
        $tableInstance = $this->getTable($table);

        if (! $tableInstance->getFilter($filterName)) {
            return;
        }

        $tableInstance->resetFilter($filterName);

        if (! $shouldTriggerUpdatedFiltersHook) {
            return;
        }

        $this->updatedTableFilters($table);
    }

    public function removeTableFilters(string $table = 'default'): void
    {
        $filters = $this->getTable($table)->getFilters();

        foreach ($filters as $filterName => $filter) {
            $this->removeTableFilter(
                $filterName,
                shouldTriggerUpdatedFiltersHook: false,
                table: $table,
            );
        }

        $this->updatedTableFilters($table);
        $this->resetTableSearch($table);
    }

    public function resetTableFilters(string $table = 'default'): void
    {
        $tableInstance = $this->getTable($table);
        $filters = [];

        foreach ($tableInstance->getFilters() as $filter) {
            $filters[$filter->getName()] = $filter->getResetState();
        }

        $tableInstance->setState('filters', $filters);

        $this->updatedTableFilters($table);
    }

    public function resetTableFiltersForm(string $table = 'default'): void
    {
        $this->getTableFiltersForm($table)->fill();

        $this->updatedTableFilters($table);
    }

    // protected function applyFiltersToTableQuery(Criteria $query): Criteria
    // {
    //     // @todo fix me
    //     $data = [];// $this->getTableFiltersForm()->getRawState();

    //     foreach ($this->getTable()->getFilters() as $filter) {

    //         $state = $data[$filter->getName()] ?? [
    //             'value' => request($filter->getName() . '-filter'),
    //         ];

    //         if ($state['value'] ?? false) {
    //             $query = $filter->table($this)->apply($query, $state);
    //         }
    //     }

    //     return $query;
    // }

    protected function applyFiltersToTableQuery(Criteria|Builder $query, string $table = 'default'): Criteria|Builder
    {
        return $this->getTable($table)->applyFiltersToQuery($query);
    }

    public function getTableFilterState(string $name, string $table = 'default'): ?array
    {
        $name = $this->parseTableFilterName($name);

        $filter = $this->getTable($table)->getFilter($name);

        if (! $filter) {
            return null;
        }

        return $filter->getState();
    }

    public function getTableFilterValue(string $name, string $table = 'default'): mixed
    {
        return $this->getTableFilterState($name, $table)['value'] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableActiveFilterValues(string $table = 'default'): array
    {
        return $this->getTable($table)->getActiveFilterValues();
    }

    public function parseTableFilterName(string $name): string
    {
        if (! class_exists($name)) {
            return $name;
        }

        if (! is_subclass_of($name, Filter::class)) {
            return $name;
        }

        return $name::getDefaultName();
    }

    public function getTableFiltersFormSchema(string $table = 'default'): array
    {
        $schema = [];

        foreach ($this->getTable($table)->getFilters() as $filter) {
            $schema[$filter->getName()] = Group::make()
                ->schema($filter->getFormSchema())
                ->statePath($filter->getName())
                ->columnSpan($filter->getColumnSpan())
                ->columnStart($filter->getColumnStart())
                ->columns($filter->getColumns());
        }

        return $schema;
    }
}
