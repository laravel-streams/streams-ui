<?php

namespace Streams\Ui\Livewire\Tables\Concerns;

use Streams\Core\Entry\Entry;
use Streams\Ui\Exceptions\Cancel;
use Streams\Ui\Builders\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;
use Streams\Core\Entry\Contract\EntryInterface;

trait HasActions
{
    protected ?Entry $cachedMountedTableActionRecord = null;

    protected int|string|null $cachedMountedTableActionRecordKey = null;

    protected function configureTableAction(Action $action): void {}

    public function callMountedTableAction(array $arguments = [], string $table = 'default'): mixed
    {
        $action = $this->getMountedTableAction($table);

        if (! $action) {
            return null;
        }

        // if (filled($this->mountedTableActionRecord) && ($action->getEntry() === null)) {
        //     return null;
        // }

        if ($action->isDisabled()) {
            return null;
        }

        $action->arguments($arguments);

        $form = $this->getMountedTableActionForm();

        $result = null;

        try {
            // if ($this->mountedTableActionHasForm()) {
            //     $action->callBeforeFormValidated();

            // $action->formData($form->getState());

            //     $action->callAfterFormValidated();
            // }

            $action->fire('before_call', [
                'action' => $action,
                'component' => $this,
                'livewire' => $this,
                'entry' => $this->getMountedTableActionRecordKey($table),
            ]);

            $result = $action->call([
                'action' => $action,
                'component' => $this,
                'livewire' => $this,
                'entry' => $this->getMountedTableActionRecordKey($table),
            ]);
            // $result = $action->callAfter() ?? $result;
            // } catch (Halt $exception) {
            // } catch (\Exception $exception) {
            //     return null;
        } catch (Cancel $exception) {
            // } catch (ValidationException $exception) {
        } catch (\Exception $exception) {
            // if (!$this->mountedTableActionShouldOpenModal()) {
            //     $action->resetArguments();
            //     $action->resetFormData();

            //     $this->unmountTableAction();
            // }

            // throw $exception;
        }

        // if (store($this)->has('redirect')) {
        //     return $result;
        // }

        $action->resetArguments();
        // $action->resetFormData();
        // $this->openActionModal($action);
        $this->unmountTableAction(table: $table);

        return $result;
    }

    // protected function openActionModal(Action $action): void
    // {
    //     // $this->dispatch('open-modal', id: "{$action->getId()}-action");
    //     $this->dispatch('open-modal');
    // }

    public function mountedTableActionRecord(int|string|null $record, string $table = 'default'): void
    {
        $this->getTable($table)->setState('mounted_action_record', $record);
    }

    public function mountTableAction(string $name, ?string $entry = null, string $table = 'default'): mixed
    {
        $mountedActions = $this->getMountedTableActions($table);
        $mountedData = $this->getMountedTableActionData($table);

        $mountedActions[] = $name;
        $mountedData[] = [];

        $this->setMountedTableActions($mountedActions, $table);
        $this->setMountedTableActionData($mountedData, $table);

        if (filled($entry)) {
            $this->mountedTableActionRecord($entry, $table);
        }

        if (! $action = $this->getMountedTableAction($table)) {

            $this->unmountTableAction(table: $table);

            return null;
        }

        $action->entry($entry);

        // if (filled($entry) && ($action->getEntry() === null)) {
        //     $this->unmountTableAction();

        //     return null;
        // }

        if ($action->isDisabled()) {

            $this->unmountTableAction();

            return null;
        }

        // $this->cacheMountedTableActionForm();

        // try {
        //     $hasForm = $this->mountedTableActionHasForm();

        //     if ($hasForm) {
        //         $action->callBeforeFormFilled();
        //     }

        // $action->mount([
        //     'form' => $this->getMountedTableActionForm(),
        // ]);

        //     if ($hasForm) {
        //         $action->callAfterFormFilled();
        //     }
        // } catch (Halt $exception) {
        //     return null;
        // } catch (Cancel $exception) {
        //     $this->unmountTableAction(shouldCancelParentActions: false);

        //     return null;
        // }

        // if ($this->mountedTableActionShouldOpenModal());
        if (! $this->mountedTableActionShouldOpenModal()) {
            return $this->callMountedTableAction(table: $table);
        }

        $this->resetErrorBag();

        $this->openTableActionModal($action);

        return null;
    }

    public function mountedTableActionShouldOpenModal(string $table = 'default'): bool
    {
        $action = $this->getMountedTableAction($table);

        if (! $action) {
            return false;
        }

        if ($action->isModalHidden()) {
            return false;
        }

        return $action->getModalHeading() ||
            $action->getModalDescription() ||
            $action->getModalContent() ||
            $action->getModalContentFooter(); // ||
        // $action->getInfolist() ||
        // $this->mountedTableActionHasForm();
    }

    public function mountedTableActionHasForm(string $table = 'default'): bool
    {
        return (bool) count($this->getMountedTableActionForm($table)?->getComponents() ?? []);
    }

    public function getMountedTableAction(string $table = 'default'): ?Action
    {
        $actions = $this->getMountedTableActions($table);

        if (! count($actions)) {
            return null;
        }

        return $this->getTable($table)->getAction($actions);
    }

    public function getMountedTableActionForm(string $table = 'default'): ?Form
    {
        // @todo
        return null;

        $action = $this->getMountedTableAction();

        if (! $action) {
            return null;
        }

        if ((! $this->isCachingForms) && $this->hasCachedForm('mountedTableActionForm')) {
            return $this->getForm('mountedTableActionForm');
        }

        return $action->getForm(
            $this->makeForm()
                ->model($this->getMountedTableActionRecord() ?? $this->getTable()->getModel())
                ->statePath('mountedTableActionsData.'.array_key_last($this->mountedTableActionsData))
                ->operation(implode('.', $this->mountedTableActions)),
        );
    }

    public function getMountedTableActionRecordKey(string $table = 'default'): int|string|null
    {
        return $this->getTable($table)->getState('mounted_action_record');
    }

    public function getMountedTableActionRecord(string $table = 'default'): ?EntryInterface
    {
        $recordKey = $this->getMountedTableActionRecordKey($table);

        if ($this->cachedMountedTableActionRecord && ($this->cachedMountedTableActionRecordKey === $recordKey)) {
            return $this->cachedMountedTableActionRecord;
        }

        $this->cachedMountedTableActionRecordKey = $recordKey;

        if (($entries = $this->getTableEntries($table)) instanceof LengthAwarePaginator) {
            $entry = $entries->first(fn ($entry) => $entry->id == $recordKey);
        } else {
            $entry = $entries->get($recordKey);
        }

        // return $this->cachedMountedTableActionRecord = $entry;
        return $entry;
    }

    protected function popMountedTableAction(string $table = 'default'): ?string
    {
        $actions = $this->getMountedTableActions($table);
        $data = $this->getMountedTableActionData($table);

        try {
            return array_pop($actions);
        } finally {
            array_pop($data);
            $this->setMountedTableActions($actions, $table);
            $this->setMountedTableActionData($data, $table);
        }
    }

    protected function resetMountedTableActionProperties(string $table = 'default'): void
    {
        $this->setMountedTableActions([], $table);
        $this->setMountedTableActionData([], $table);
    }

    public function unmountTableAction(bool $shouldCancelParentActions = true, string $table = 'default'): void
    {
        $action = $this->getMountedTableAction($table);

        if ($action) {
            $this->popMountedTableAction($table);
        }// elseif ($action->shouldCancelAllParentActions()) {
        //     $this->resetMountedTableActionProperties();
        // } else {
        //     $parentActionToCancelTo = $action->getParentActionToCancelTo();

        //     while (true) {
        //         $recentlyClosedParentAction = $this->popMountedTableAction();

        //         if (
        //             blank($parentActionToCancelTo) ||
        //             ($recentlyClosedParentAction === $parentActionToCancelTo)
        //         ) {
        //             break;
        //         }
        //     }
        // }

        $this->closeTableActionModal();

        if (! count($this->getMountedTableActions($table))) {
            // $this->closeTableActionModal($action);

            $action?->entry(null);
            $this->mountedTableActionRecord(null, $table);

            return;
        }

        $this->cacheMountedTableActionForm();

        $this->resetErrorBag();

        $this->openTableActionModal($action);
    }

    protected function cacheMountedTableActionForm(): void
    {
        // @todo
        // $this->cacheForm(
        //     'mountedTableActionForm',
        //     fn () => $this->getMountedTableActionForm(),
        // );
    }

    // protected function closeTableActionModal(Action $action): void
    protected function closeTableActionModal(): void
    {
        // $this->dispatch('close-modal', id: "{$action->getId()}-table-action");
        $this->dispatch('close-modal');
    }

    // protected function openTableActionModal(Action $action): void
    protected function openTableActionModal(): void
    {
        // $this->dispatch('open-modal', id: "{$action->getId()}-action");
        $this->dispatch('open-modal');
    }

    /**
     * @deprecated Override the `table()` method to configure the table.
     *
     * @return array<Action | ActionGroup>
     */
    protected function getTableActions(): array
    {
        return [];
    }

    /**
     * @deprecated Override the `table()` method to configure the table.
     */
    protected function getTableActionsColumnLabel(): ?string
    {
        return null;
    }

    public function mountedTableActionInfolist(): Infolist
    {
        return $this->getMountedTableAction()->getInfolist();
    }

    protected function getMountedTableActions(string $table = 'default'): array
    {
        return $this->getTable($table)->getState('mounted_actions', []);
    }

    protected function setMountedTableActions(array $actions, string $table = 'default'): void
    {
        $this->getTable($table)->setState('mounted_actions', $actions);
    }

    protected function getMountedTableActionData(string $table = 'default'): array
    {
        return $this->getTable($table)->getState('mounted_actions_data', []);
    }

    protected function setMountedTableActionData(array $data, string $table = 'default'): void
    {
        $this->getTable($table)->setState('mounted_actions_data', $data);
    }
}
