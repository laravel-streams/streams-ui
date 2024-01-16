<?php

namespace Streams\Ui\Components\Tables\Concerns;

use Illuminate\Support\Arr;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Tables\Filters\Filter;
use Streams\Ui\Forms\Form;

trait HasFilters
{
    public ?array $tableFilters = [
        'search' => [
            'value' => null,
        ],
    ];

    public function getTableFiltersForm(): Form
    {
        return $this->once(__FUNCTION__, function () {
            return $this->makeForm()
                ->schema($this->getTableFiltersFormSchema())
                ->columns($this->getTable()->getFiltersFormColumns())
                ->model($this->getTable()->getModel())
                ->statePath('tableFilters')
                ->live();
        });
    }

    public function updatedTableFilters(): void
    {
        // if ($this->getTable()->persistsFiltersInSession()) {
        //     session()->put(
        //         $this->getTableFiltersSessionKey(),
        //         $this->tableFilters,
        //     );
        // }

        // if ($this->getTable()->shouldDeselectAllRecordsWhenFiltered()) {
        //     $this->deselectAllTableRecords();
        // }

        $this->resetPage();
    }

    public function removeTableFilter(
        string $filterName,
        ?string $field = null,
        bool $shouldTriggerUpdatedFiltersHook = true
    ): void {

        $filter = $this->getTable()->getFilter($filterName);
        $filterResetState = $filter->getResetState();

        $filterFormGroup = $this->getTableFiltersForm()->getComponents()[$filterName] ?? null;
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

        if (!$shouldTriggerUpdatedFiltersHook) {
            return;
        }

        $this->updatedTableFilters();
    }

    public function removeTableFilters(): void
    {
        $filters = $this->getTable()->getFilters();

        foreach ($filters as $filterName => $filter) {
            $this->removeTableFilter(
                $filterName,
                shouldTriggerUpdatedFiltersHook: false,
            );
        }

        $this->updatedTableFilters();

        $this->resetTableSearch();
        $this->resetTableColumnSearches();
    }

    public function resetTableFiltersForm(): void
    {
        $this->getTableFiltersForm()->fill();

        $this->updatedTableFilters();
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

    protected function applyFiltersToTableQuery(Criteria $query): Criteria
    {
        // $data = $this->getTableFiltersForm()->getRawState();
        $data = $this->tableFilters;

        // foreach ($this->getTable()->getFilters() as $filter) {
        //     $filter->applyToBaseQuery(
        //         $query,
        //         $data[$filter->getName()] ?? [],
        //     );
        // }

        foreach ($this->getTable()->getFilters() as $filter) {
            // $filter->apply($query, $data[$filter->getName()] ?? []);
            if ($state = Arr::get($data, $filter->getName() . '.value')) {
                $filter->apply($query, $this->getTable(), $state);
            }
        }

        return $query;
    }

    public function getTableFilterState(string $name): ?array
    {
        return $this->getTableFiltersForm()->getRawState()[$this->parseTableFilterName($name)] ?? null;
    }

    public function parseTableFilterName(string $name): string
    {
        if (!class_exists($name)) {
            return $name;
        }

        if (!is_subclass_of($name, Filter::class)) {
            return $name;
        }

        return $name::getDefaultName();
    }

    public function getTableFiltersFormSchema(): array
    {
        $schema = [];

        foreach ($this->getTable()->getFilters() as $filter) {
            $schema[$filter->getName()] = Forms\Components\Group::make()
                ->schema($filter->getFormSchema())
                ->statePath($filter->getName())
                ->columnSpan($filter->getColumnSpan())
                ->columnStart($filter->getColumnStart())
                ->columns($filter->getColumns());
        }

        return $schema;
    }

    public function getTableFiltersSessionKey(): string
    {
        $table = class_basename($this::class);

        return "tables.{$table}_filters";
    }
}
