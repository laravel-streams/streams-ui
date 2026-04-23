<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Streams\Core\Criteria\Criteria;
use Illuminate\Contracts\Database\Query\Builder;

trait CanSearchEntries
{
    public function setTableSearch(string $table, ?string $search = null): void
    {
        $this->getTable($table)->setState('search', strval($search));
        $this->resetPage(table: $table);
    }

    protected function applySearchToTableQuery(Criteria|Builder $query, string $table = 'default'): Criteria|Builder
    {
        return $this->getTable($table)->applySearchToQuery($query);
    }

    public function getTableSearch(string $table = 'default'): ?string
    {
        return $this->getTable($table)->getSearch();
    }

    public function hasTableSearch(string $table = 'default'): bool
    {
        return filled($this->getTableSearch($table));
    }

    public function resetTableSearch(string $table = 'default'): void
    {
        $this->setTableSearch($table, '');
    }
}
