<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Illuminate\Support\Collection;
use Streams\Core\Criteria\Criteria;
use Streams\Ui\Builders\Forms\Form;
use Streams\Ui\Support\Facades\Actions;
use Streams\Ui\Notifications\Notification;
use Streams\Ui\Builders\Tables\BulkActions\BulkAction;
use Illuminate\Contracts\Database\Query\Builder;

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

            // Select-all-matching is resolved here into paged ID lists so bulk
            // action closures only ever receive selectedEntries (no query branch).
            // IDs are snapshotted before handlers run so mutations cannot skip pages.
            $pages = $this->getBulkActionSelectedEntryPages($table);
            $pageCount = count($pages);

            foreach ($pages as $index => $selectedEntries) {
                $result = $action->call([
                    'component' => $this,
                    'livewire' => $this,
                    'table' => $this->getTable($table),
                    'selectedEntries' => $selectedEntries,
                    'arguments' => array_merge($arguments, [
                        'bulk_page' => $index + 1,
                        'bulk_pages' => $pageCount,
                    ]),
                ]);
            }

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

        // Resolve matching mode before touching selection. Alpine may pass false
        // after a remorph even when Livewire still has select_all_matching=true
        // (persisted when the user clicked "Select all N matching").
        if (! $selectAllMatching) {
            $selectAllMatching = $this->isSelectAllMatchingTable($table);
        }

        $this->setSelectAllMatchingTable($selectAllMatching, $table);

        if ($selectAllMatching) {
            // Snapshot ignores checkbox keys; do not let an empty Alpine payload
            // wipe Livewire selection state mid-mount.
            if (is_array($selectedRecords) && $selectedRecords !== []) {
                $this->setSelectedTableEntries($selectedRecords, $table);
            }
        } elseif ($selectedRecords !== null) {
            $this->setSelectedTableEntries($selectedRecords, $table);
        } elseif ($selectedRecords = $this->getSelectedTableEntries($table)) {
            $this->setSelectedTableEntries($selectedRecords, $table);
        }

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
     * Uses the same entry set as the rendered table so the count respects filters.
     */
    public function getFilteredTableRecordsCount(string $table = 'default'): int
    {
        $entries = $this->getTableEntries($table);

        if (method_exists($entries, 'total')) {
            return (int) $entries->total();
        }

        if ($entries instanceof Collection) {
            return $entries->count();
        }

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
     * Resolve the entry IDs the mounted bulk action should process, chunked into
     * pages. Matching mode snapshots the full filtered ID list first (so later
     * pages stay correct even when handlers mutate rows out of the filter), then
     * yields page-sized selectedEntries arrays. Non-matching uses checkbox keys.
     * Actions always receive a simple selectedEntries list — never a query.
     *
     * @return list<list<string>>
     */
    public function getBulkActionSelectedEntryPages(string $table = 'default'): array
    {
        $keys = $this->resolveBulkActionEntryKeys($table);

        if ($keys === []) {
            return [];
        }

        $chunkSize = $this->resolveBulkActionChunkSize($table);

        /** @var list<list<string>> $pages */
        $pages = array_values(array_chunk($keys, $chunkSize));

        return $pages;
    }

    /**
     * Snapshot every entry ID the mounted bulk action should process.
     *
     * Matching mode reads the full filtered/sorted query once (not the current
     * page). Loading IDs up front avoids offset pagination skipping rows after
     * handlers mutate the filtered set (e.g. archive → status leaves "active").
     *
     * @return list<string>
     */
    public function resolveBulkActionEntryKeys(string $table = 'default'): array
    {
        if ($this->isSelectAllMatchingTable($table)) {
            return $this->snapshotFilteredSortedEntryKeys($table);
        }

        return array_values(array_map(
            static fn ($key): string => (string) $key,
            $this->getSelectedTableEntries($table),
        ));
    }

    /**
     * @return list<string>
     */
    protected function snapshotFilteredSortedEntryKeys(string $table = 'default'): array
    {
        $chunkSize = $this->resolveBulkActionChunkSize($table);
        $keys = [];
        $page = 1;

        do {
            $query = $this->getFilteredSortedQuery($table);
            $pageKeys = [];
            $lastPage = $page;

            if ($query instanceof Criteria) {
                $paginator = $query->paginate([
                    'per_page' => $chunkSize,
                    'page' => $page,
                    'page_name' => '__bulk_matching_snapshot',
                ]);
                $pageKeys = $this->entryKeysFromItems(collect($paginator->items()));
                $lastPage = method_exists($paginator, 'lastPage')
                    ? max(1, (int) $paginator->lastPage())
                    : $page;
            } elseif ($query instanceof Builder) {
                $total = (int) (clone $query)->count();
                $lastPage = max(1, (int) ceil($total / $chunkSize));
                $pageKeys = $this->entryKeysFromItems(
                    (clone $query)->forPage($page, $chunkSize)->get()
                );
            } else {
                $pageKeys = $this->entryKeysFromItems(collect($query->get()));
                $lastPage = $page;
            }

            if ($pageKeys === []) {
                break;
            }

            foreach ($pageKeys as $key) {
                $keys[] = $key;
            }

            $page++;
        } while ($page <= $lastPage);

        return array_values(array_unique($keys));
    }

    /**
     * @param  Collection<int, mixed>  $items
     * @return list<string>
     */
    protected function entryKeysFromItems(Collection $items): array
    {
        return $items
            ->map(static function (mixed $entry): string {
                if (is_object($entry)) {
                    return (string) ($entry->id ?? '');
                }

                if (is_array($entry)) {
                    return (string) ($entry['id'] ?? '');
                }

                return '';
            })
            ->filter(static fn (string $id): bool => $id !== '')
            ->values()
            ->all();
    }

    protected function resolveBulkActionChunkSize(string $table = 'default'): int
    {
        // Snapshot/process in stable chunks — do not mirror UI per-page (users
        // often set per-page to 1 while selecting all matching results).
        return 100;
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
