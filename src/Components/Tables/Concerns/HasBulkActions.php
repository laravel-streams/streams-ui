<?php

namespace Streams\Ui\Components\Tables\Concerns;

use Streams\Ui\Forms\Form;
use Streams\Core\Entry\Entry;
use Illuminate\Support\Collection;
use Streams\Ui\Tables\BulkActions\BulkAction;
use Streams\Ui\Exceptions\ValidationException;
use Illuminate\Pagination\LengthAwarePaginator;

trait HasBulkActions
{
    public array $selectedTableEntries = [];

    public ?string $mountedTableBulkAction = null;

    public ?array $mountedTableBulkActionData = [];

    protected Collection $cachedSelectedTableRecords;

    protected function configureTableBulkAction(BulkAction $action): void
    {
    }

    public function callMountedTableBulkAction(array $arguments = []): mixed
    {
        $action = $this->getMountedTableBulkAction();

        if (!$action) {
            return null;
        }

        // @todo should this be here?
        // Move to mountTableBulkAction()
        // if ($action->isDisabled()) {
        //     return null;
        // }

        $action->arguments($arguments);

        // $form = $this->getMountedTableBulkActionForm();

        $result = null;

        try {
            // if ($this->mountedTableBulkActionHasForm()) {
            //     $action->callBeforeFormValidated();

            //     $action->formData($form->getState());

            //     $action->callAfterFormValidated();
            // }

            $action->fire('before_call');

            $result = $action->call([
                'table' => $this->table,
                'selectedEntries' => $this->selectedTableEntries
            ]);

            $result = $action->fire('after_call') ?? $result;

            // } catch (Halt $exception) {
            //     return null;
            // } catch (Cancel $exception) {
        } catch (ValidationException $exception) {
            if (!$this->mountedTableBulkActionShouldOpenModal()) {
                $action->resetArguments();
                $action->resetFormData();

                $this->unmountTableBulkAction();
            }

            throw $exception;
        }

        // if (store($this)->has('redirect')) {
        //     return $result;
        // }

        $action->resetArguments();
        // $action->resetFormData();

        $this->unmountTableBulkAction();

        return $result;
    }

    public function mountTableBulkAction(
        string $name,
        ?array $selectedRecords = null
    ): mixed {

        $this->mountedTableBulkAction = $name;

        if ($selectedRecords !== null) {
            $this->selectedTableEntries = $selectedRecords;
        }

        $action = $this->getMountedTableBulkAction();

        // @todo Replace this
        return $this->callMountedTableBulkAction();

        if (!$action) {
            return null;
        }

        if ($action->isDisabled()) {
            return null;
        }

        $this->cacheMountedTableBulkActionForm();

        try {
            // $hasForm = $this->mountedTableBulkActionHasForm();

            // if ($hasForm) {
            //     $action->callBeforeFormFilled();
            // }

            // $action->mount([
            //     'form' => $this->getMountedTableBulkActionForm(),
            // ]);

            // if ($hasForm) {
            //     $action->callAfterFormFilled();
            // }
            // } catch (Halt $exception) {
        } catch (\Exception $exception) {
            return null;
            // } catch (Cancel $exception) {
        } catch (\Exception $exception) {
            $this->resetMountedTableBulkActionProperties();

            return null;
        }

        if (!$this->mountedTableBulkActionShouldOpenModal()) {
            return $this->callMountedTableBulkAction();
        }

        $this->resetErrorBag();

        $this->openTableBulkActionModal();

        return null;
    }

    protected function cacheMountedTableBulkActionForm(): void
    {
        // $this->cacheForm(
        //     'mountedTableBulkActionForm',
        //     fn () => $this->getMountedTableBulkActionForm(),
        // );
    }

    protected function resetMountedTableBulkActionProperties(): void
    {
        $this->mountedTableBulkAction = null;
        $this->selectedTableEntries = [];
    }

    public function mountedTableBulkActionShouldOpenModal(): bool
    {
        $action = $this->getMountedTableBulkAction();

        if ($action->isModalHidden()) {
            return false;
        }

        return $action->getModalDescription() ||
            $action->getModalContent() ||
            $action->getModalContentFooter() ||
            $action->getInfolist() ||
            $this->mountedTableBulkActionHasForm();
    }

    public function unmountTableBulkAction(): void
    {
        $this->mountedTableBulkAction = null;
        $this->selectedTableEntries = [];

        $this->closeTableBulkActionModal();
    }

    public function mountedTableBulkActionHasForm(): bool
    {
        return (bool) count($this->getMountedTableBulkActionForm()?->getComponents() ?? []);
    }

    public function deselectAllTableRecords(): void
    {
        $this->dispatch('deselectAllTableRecords');
    }

    /**
     * @return array<string>
     */
    public function getAllSelectableTableRecordKeys(): array
    {
        $query = $this->getFilteredTableQuery();

        if (!$this->getTable()->checksIfRecordIsSelectable()) {
            $records = $this->getTable()->selectsCurrentPageOnly() ?
                $this->getTableRecords() :
                $query;

            return $records
                ->pluck($query->getModel()->getQualifiedKeyName())
                ->map(fn ($key): string => (string) $key)
                ->all();
        }

        $records = $this->getTable()->selectsCurrentPageOnly() ?
            $this->getTableRecords() :
            $query->get();

        return $records->reduce(
            function (array $carry, Entry $record): array {
                if (!$this->getTable()->isRecordSelectable($record)) {
                    return $carry;
                }

                $carry[] = (string) $record->getKey();

                return $carry;
            },
            initial: [],
        );
    }

    /**
     * @return array<string>
     */
    public function getGroupedSelectableTableRecordKeys(string $group): array
    {
        $query = $this->getFilteredTableQuery();

        $tableGrouping = $this->getTableGrouping();

        $tableGrouping->scopeQueryByKey($query, $group);

        if (!$this->getTable()->checksIfRecordIsSelectable()) {
            $records = $this->getTable()->selectsCurrentPageOnly() ?
                $this->getTableRecords()->filter(
                    fn (Entry $record) => $tableGrouping->getStringKey($record) === $group,
                ) :
                $query;

            return $records
                ->pluck($query->getModel()->getQualifiedKeyName())
                ->map(fn ($key): string => (string) $key)
                ->all();
        }

        $records = $this->getTable()->selectsCurrentPageOnly() ?
            $this->getTableRecords()->filter(
                fn (Entry $record) => $tableGrouping->getStringKey($record) === $group,
            ) :
            $query->get();

        return $records->reduce(
            function (array $carry, Entry $record): array {
                if (!$this->getTable()->isRecordSelectable($record)) {
                    return $carry;
                }

                $carry[] = (string) $record->getKey();

                return $carry;
            },
            initial: [],
        );
    }

    public function getAllSelectableTableRecordsCount(): int
    {
        if ($this->getTable()->checksIfRecordIsSelectable()) {
            $records = $this->getTable()->selectsCurrentPageOnly() ?
                $this->getTableRecords() :
                $this->getFilteredTableQuery()->get();

            return $records
                ->filter(fn (Entry $record): bool => $this->getTable()->isRecordSelectable($record))
                ->count();
        }

        if ($this->getTable()->selectsCurrentPageOnly()) {
            return $this->records->count();
        }

        if ($this->records instanceof LengthAwarePaginator) {
            return $this->records->total();
        }

        return $this->getFilteredTableQuery()->count();
    }

    public function getSelectedTableRecords(): Collection
    {
        // @todo this is not done
        return $this->getTable()
            ->getQuery()
            ->where('id', 'IN', $this->selectedTableEntries)
            ->get();

        if (isset($this->cachedSelectedTableRecords)) {
            return $this->cachedSelectedTableRecords;
        }

        $table = $this->getTable();

        if (!($table->getRelationship() instanceof BelongsToMany && $table->allowsDuplicates())) {
            $query = $table->getQuery()->whereKey($this->selectedTableEntries);
            $this->applySortingToTableQuery($query);

            foreach ($this->getTable()->getColumns() as $column) {
                $column->applyEagerLoading($query);
                $column->applyRelationshipAggregates($query);
            }

            if ($table->shouldDeselectAllRecordsWhenFiltered()) {
                $this->filterTableQuery($query);
            }

            return $this->cachedSelectedTableRecords = $query->get();
        }

        /** @var BelongsToMany $relationship */
        $relationship = $table->getRelationship();

        $pivotClass = $relationship->getPivotClass();
        $pivotKeyName = app($pivotClass)->getKeyName();

        $relationship->wherePivotIn($pivotKeyName, $this->selectedTableEntries);

        foreach ($this->getTable()->getColumns() as $column) {
            $column->applyEagerLoading($relationship);
            $column->applyRelationshipAggregates($relationship);
        }

        return $this->cachedSelectedTableRecords = $this->hydratePivotRelationForTableRecords(
            $table->selectPivotDataInQuery($relationship)->get(),
        );
    }

    protected function closeTableBulkActionModal(): void
    {
        $this->dispatch('close-modal', id: "{$this->getId()}-table-bulk-action");
    }

    protected function openTableBulkActionModal(): void
    {
        $this->dispatch('open-modal', id: "{$this->getId()}-table-bulk-action");
    }

    public function getMountedTableBulkAction(): ?BulkAction
    {
        if (!$this->mountedTableBulkAction) {
            return null;
        }

        return $this->getTable()->getBulkAction($this->mountedTableBulkAction);
    }

    public function getMountedTableBulkActionForm(): ?Form
    {
        $action = $this->getMountedTableBulkAction();

        if (!$action) {
            return null;
        }

        if (
            (!$this->isCachingForms)
            && $this->hasCachedForm('mountedTableBulkActionForm')
        ) {
            return $this->getForm('mountedTableBulkActionForm');
        }

        return $action->getForm(
            $this->makeForm()
                ->model($this->getTable()->getModel())
                ->statePath('mountedTableBulkActionData')
                ->operation($this->mountedTableBulkAction),
        );
    }

    // public function mountedTableBulkActionInfolist(): Infolist
    // {
    //     return $this->getMountedTableBulkAction()->getInfolist();
    // }
}
