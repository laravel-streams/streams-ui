<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Streams\Core\Criteria\Criteria;
use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Builders\Tables\Filters\Filter;
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
        $filter = $tableInstance->getFilter($filterName);
        $filterResetState = $filter->getResetState();

        $filterFormGroup = $this->getTableFiltersForm($table)->getComponents()[$filterName] ?? null;
        $filterFields = $filterFormGroup?->getChildComponentContainer()->getFlatFields();

        if (filled($field) && array_key_exists($field, $filterFields)) {
            $filterFields = [$field => $filterFields[$field]];
        }

        foreach ($filterFields as $fieldName => $field) {
            $state = $field->getState();

            $field->state($filterResetState[$fieldName] ?? match (true) {
                is_array($state) => [],
                is_bool($state) => false,
                default => null,
            });
        }

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
        $this->getTable($table)->setState('filters', []);
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
        return $this->getTableFiltersForm($table)->getRawState()[$this->parseTableFilterName($name)] ?? null;
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
            $schema[$filter->getName()] = \Streams\Ui\Builders\Forms\Components\Group::make()
                ->schema($filter->getFormSchema())
                ->statePath($filter->getName())
                ->columnSpan($filter->getColumnSpan())
                ->columnStart($filter->getColumnStart())
                ->columns($filter->getColumns());
        }

        return $schema;
    }

}
