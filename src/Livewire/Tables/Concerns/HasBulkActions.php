<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Illuminate\Support\Collection;
use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Support\Facades\Actions;
use Streams\Ui\Notifications\Notification;
use Streams\Ui\Builders\Tables\BulkActions\BulkAction;

trait HasBulkActions
{
    protected function configureBulkAction(BulkAction $action): void {}

    public function callMountedTableBulkAction(array $arguments = [], string $table = 'default'): mixed
    {
        $action = $this->getMountedTableBulkAction($table);

        if (! $action) {
            return null;
        }

        $action->arguments($arguments);

        $result = null;

        try {
            if ($form = $this->getMountedTableBulkActionForm($table)) {
                $action->formData($form->getState());
            }

            $action->fire('before_call');

            $selectAllMatching = $this->isSelectAllMatchingTable($table);

            $result = $action->call([
                'component' => $this,
                'livewire' => $this,
                'table' => $this->getTable($table),
                'selectedEntries' => $selectAllMatching ? [] : $this->getSelectedTableEntries($table),
                'selectAllMatching' => $selectAllMatching,
                'query' => $this->getFilteredSortedQuery($table),
                'arguments' => $arguments,
            ]);

            $action->fire('after_call');

        } catch (\Throwable $exception) {
            Notification::make()
                ->title('Error')
                ->description($exception->getMessage())
                ->danger()
                ->send();

            return null;
        }

        $action->resetArguments();
        $this->unmountTableBulkAction($table);
        $this->deselectAllTableRecords();
        unset($this->entries[$table]);

        return $result;
    }

    public function mountTableBulkAction(
        string $name,
        ?array $selectedRecords = null,
        string $table = 'default',
        bool $selectAllMatching = false,
    ): mixed {
        $table = $this->resolveTableForBulkAction($name, $table);

        $this->setMountedTableBulkActionName($name, $table);

        if ($selectedRecords !== null) {
            $this->setSelectedTableEntries($selectedRecords, $table);
        } elseif ($selectedRecords = $this->getSelectedTableEntries($table)) {
            $this->setSelectedTableEntries($selectedRecords, $table);
        }

        // Alpine may pass the flag; wire:click-only mounts rely on synced Livewire state.
        if (! $selectAllMatching) {
            $selectAllMatching = $this->isSelectAllMatchingTable($table);
        }

        $this->setSelectAllMatchingTable($selectAllMatching, $table);

        $action = $this->getMountedTableBulkAction($table);

        if (! $action) {
            return null;
        }

        if ($action->isDisabled()) {
            return null;
        }

        try {
            // noop, reserved for form mounting
        } catch (\Throwable $exception) {
            $this->resetMountedTableBulkActionProperties($table);

            return null;
        }

        if (! $this->mountedTableBulkActionShouldOpenModal($table)) {
            return $this->callMountedTableBulkAction(table: $table);
        }

        $this->resetErrorBag();

        $this->openTableBulkActionModal();

        return null;
    }

    protected function resetMountedTableBulkActionProperties(string $table = 'default'): void
    {
        $this->setMountedTableBulkActionName(null, $table);
        $this->setSelectedTableEntries([], $table);
        $this->setSelectAllMatchingTable(false, $table);
    }

    public function mountedTableBulkActionShouldOpenModal(string $table = 'default'): bool
    {
        $action = $this->getMountedTableBulkAction($table);

        if (! $action) {
            return false;
        }

        if ($action->isModalHidden()) {
            return false;
        }

        return $action->getModalHeading() ||
            $action->getModalDescription() ||
            $action->getModalContent() ||
            $action->getModalContentFooter();
        // $action->getInfolist() ||
        // $this->mountedActionHasForm();
    }

    public function unmountTableBulkAction(string $table = 'default'): void
    {
        $this->setMountedTableBulkActionName(null, $table);
        $this->setSelectedTableEntries([], $table);
        $this->setSelectAllMatchingTable(false, $table);

        $this->closeTableBulkActionModal();
    }

    public function mountedTableBulkActionHasForm(string $table = 'default'): bool
    {
        return (bool) count($this->getMountedTableBulkActionForm($table)?->getComponents() ?? []);
    }

    public function deselectAllTableRecords(): void
    {
        foreach (array_keys($this->getCachedTables()) as $table) {
            $this->setSelectedTableEntries([], $table);
            $this->setSelectAllMatchingTable(false, $table);
        }

        $this->dispatch('deselectAllTableEntries');
    }

    protected function closeTableBulkActionModal(): void
    {
        // $this->dispatch('close-modal', id: "{$this->getId()}-table-bulk-action");
        $this->dispatch('close-modal');
    }

    protected function openTableBulkActionModal(): void
    {
        // $this->dispatch('open-modal', id: "{$this->getId()}-table-bulk-action");
        $this->dispatch('open-modal');
    }

    public function getMountedTableBulkAction(string $table = 'default'): ?BulkAction
    {
        $mounted = $this->getMountedTableBulkActionName($table);

        if (! $mounted) {
            return null;
        }

        if ($action = Actions::resolve($mounted)) {
            $action->table($this->getTable($table));
            $this->configureBulkAction($action);

            return $action;
        }

        return $this->getTable($table)->getBulkAction($mounted);
    }

    public function getMountedTableBulkActionForm(string $table = 'default'): ?Form
    {
        $action = $this->getMountedTableBulkAction($table);

        if (! $action) {
            return null;
        }

        $form = $action->getForm();

        return $form ?: $this->extractFormFromBulkActionComponents($action->getModalComponents());
    }

    protected function extractFormFromBulkActionComponents(array $components): ?Form
    {
        foreach ($components as $component) {
            if ($component instanceof Form) {
                return $component;
            }

            if (method_exists($component, 'getComponents')) {
                return $this->extractFormFromBulkActionComponents($component->getComponents());
            }
        }

        return null;
    }

    public function getSelectedTableRecords(string $table = 'default'): Collection
    {
        return $this->getTable($table)
            ->getQuery()
            ->where('id', 'IN', $this->getSelectedTableEntries($table))
            ->get();
    }

    public function getAllSelectableTableEntryKeys(string $table = 'default'): array
    {
        return $this->getTableEntries($table)
            ->pluck('id')
            ->map(fn ($key): string => (string) $key)
            ->all();
    }

    /**
     * Filtered/search result size for select-all-matching (not the current page).
     */
    public function getFilteredTableRecordsCount(string $table = 'default'): int
    {
        $query = $this->getFilteredQuery($table);

        if (method_exists($query, 'count')) {
            return (int) $query->count();
        }

        return (int) $query->get()->count();
    }

    public function getSelectedTableEntries(string $table = 'default'): array
    {
        return $this->getTable($table)->getSelectedEntryKeys();
    }

    public function setSelectedTableEntries(array $keys, string $table = 'default'): void
    {
        $this->getTable($table)->setSelectedEntryKeys($keys);
    }

    public function isSelectAllMatchingTable(string $table = 'default'): bool
    {
        return (bool) $this->getTable($table)->getState('select_all_matching', false);
    }

    public function setSelectAllMatchingTable(bool $selectAllMatching, string $table = 'default'): void
    {
        $this->getTable($table)->setState('select_all_matching', $selectAllMatching);
    }

    /**
     * @return list<int|string>
     */
    public function resolveBulkActionEntryKeys(string $table = 'default'): array
    {
        if ($this->isSelectAllMatchingTable($table)) {
            return $this->getFilteredSortedQuery($table)
                ->get()
                ->pluck('id')
                ->map(static fn ($id): string => (string) $id)
                ->values()
                ->all();
        }

        return array_map(
            static fn ($key): string => (string) $key,
            $this->getSelectedTableEntries($table),
        );
    }

    protected function getMountedTableBulkActionName(string $table = 'default'): ?string
    {
        return $this->getTable($table)->getState('mounted_bulk_action');
    }

    protected function setMountedTableBulkActionName(?string $name, string $table = 'default'): void
    {
        $this->getTable($table)->setState('mounted_bulk_action', $name);
    }

    protected function resolveTableForBulkAction(string $name, string $table): string
    {
        if ($table !== 'default') {
            return $table;
        }

        foreach ($this->getCachedTables() as $tableName => $tableInstance) {
            if (array_key_exists($name, $tableInstance->getFlatBulkActions())) {
                return $tableName;
            }
        }

        $resolved = Actions::resolve($name);

        if ($resolved instanceof BulkAction) {
            return $resolved->getTable()->getName();
        }

        return $table;
    }
}
