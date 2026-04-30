<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

trait HasViews
{
    public function applyTableView(string $name, string $table = 'default'): void
    {
        $tableInstance = $this->getTable($table);
        $view = $tableInstance->getTableView($name);

        if (! $view || $view->isDisabled()) {
            return;
        }

        $tableInstance->setState('active_view', $name);
        $view->apply($tableInstance);
        $tableInstance->flushEntries();
        $this->resetPage(table: $table);
    }

    public function getActiveTableView(string $table = 'default'): ?string
    {
        $tableInstance = $this->getTable($table);
        $active = $tableInstance->getState('active_view');

        if ($active && $tableInstance->getTableView($active)) {
            return $active;
        }

        $default = $tableInstance->getDefaultView();

        if ($default && $tableInstance->getTableView($default)) {
            return $default;
        }

        return null;
    }
}
