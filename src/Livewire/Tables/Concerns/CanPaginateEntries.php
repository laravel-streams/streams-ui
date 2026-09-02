<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Database\Query\Builder;

trait CanPaginateEntries
{
    protected int|string|null $defaultTableRecordsPerPageSelectOption = null;

    public function updatedData($value, string $key): void
    {
        if (! str_starts_with($key, 'tables.')) {
            return;
        }

        $parts = explode('.', $key);
        $table = $parts[1] ?? 'default';
        $field = implode('.', array_slice($parts, 2));

        // Filter inputs bind to filters.{name}.value — not the bare "filters" key.
        $filtersChanged = $field === 'filters' || str_starts_with($field, 'filters.');

        if (
            $filtersChanged
            || in_array($field, ['search', 'records_per_page', 'sort.column', 'sort.direction'], true)
        ) {
            $this->resetPage(table: $table);
        }
    }

    protected function paginateQuery(Criteria|Builder $query, string $table = 'default'): Paginator
    {
        return $this->getTable($table)->paginate($query);
    }

    public function getTableRecordsPerPage(string $table = 'default'): int|string|null
    {
        return $this->getTable($table)->getRecordsPerPage();
    }

    public function getTablePage(string $table = 'default'): int
    {
        return $this->getPage($this->getTablePaginationPageName($table));
    }

    public function getDefaultTableRecordsPerPageSelectOption(string $table = 'default'): int|string
    {
        $tableInstance = $this->getTable($table);
        $option = $tableInstance->getState(
            'records_per_page',
            $this->defaultTableRecordsPerPageSelectOption ?? $tableInstance->getDefaultPaginationPageOption(),
        );

        $pageOptions = $tableInstance->getPaginationOptions();

        if (in_array($option, $pageOptions)) {
            return $option;
        }

        $tableInstance->setState('records_per_page', $pageOptions[0]);

        return $pageOptions[0];
    }

    public function getTablePaginationPageName(string $table = 'default'): string
    {
        return $this->getQueryStringPropertyName('page', $table);
    }

    /**
     * @deprecated Override the `table()` method to configure the table.
     *
     * @return array<int | string> | null
     */
    protected function getTableRecordsPerPageSelectOptions(): ?array
    {
        return null;
    }

    /**
     * @deprecated Override the `table()` method to configure the table.
     */
    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }
}
