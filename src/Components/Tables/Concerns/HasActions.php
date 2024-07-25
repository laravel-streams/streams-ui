<?php

namespace Streams\Ui\Components\Tables\Concerns;

use Streams\Core\Entry\Entry;
use Streams\Ui\Actions\Action;
use Illuminate\Pagination\LengthAwarePaginator;
use Streams\Ui\Exceptions\Cancel;
use Streams\Ui\Exceptions\Halt;

trait HasActions
{
    public ?array $mountedTableActions = [];

    public ?array $mountedTableActionsData = [];

    public $mountedTableActionRecord = null;

    protected ?Entry $cachedMountedTableActionRecord = null;

    protected int | string | null $cachedMountedTableActionRecordKey = null;

    protected function configureTableAction(Action $action): void
    {
    }

    public function callMountedTableAction(array $arguments = []): mixed
    {
        $action = $this->getMountedTableAction();

        if (!$action) {
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

            //     $action->formData($form->getState());

            //     $action->callAfterFormValidated();
            // }

            // $action->callBefore();
            $result = $action->call([
                'component' => $this,
                'entry' => $this->mountedTableActionRecord,
            ]);
            
            // $result = $action->callAfter() ?? $result;
        // } catch (Halt $exception) {
        } catch (\Exception $exception) {
            return null;
        } catch (Cancel $exception) {
        // } catch (ValidationException $exception) {
        } catch (\Exception $exception) {
            if (!$this->mountedTableActionShouldOpenModal()) {
                $action->resetArguments();
                $action->resetFormData();

                $this->unmountTableAction();
            }

            throw $exception;
        }

        // if (store($this)->has('redirect')) {
        //     return $result;
        // }

        $action->resetArguments();
        // $action->resetFormData();
        
        $this->openActionModal($action);
        // $this->unmountTableAction();

        return $result;
    }

    protected function openActionModal(Action $action): void
    {
        dd("{$action->getId()}-action");
        $this->dispatch('open-modal', id: "{$action->getId()}-action");
    }

    public function mountedTableActionRecord(int | string | null $record): void
    {
        $this->mountedTableActionRecord = $record;
    }

    public function mountTableAction(string $name, ?string $entry = null): mixed
    {
        $this->mountedTableActions[] = $name;
        $this->mountedTableActionsData[] = [];

        if (count($this->mountedTableActions) === 1) {
            $this->mountedTableActionRecord($entry);
        }

        if (!$action = $this->getMountedTableAction()) {
            
            $this->unmountTableAction();

            return null;
        }

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
        if (!$this->mountedTableActionShouldOpenModal()) {
            return $this->callMountedTableAction();
        }

        $this->resetErrorBag();

        $this->openTableActionModal($action);
        
        return null;
    }

    public function mountedTableActionShouldOpenModal(): bool
    {
        $action = $this->getMountedTableAction();

        if ($action->isModalHidden()) {
            return false;
        }
        
        return $action->getModalDescription() ||
            $action->getModalContent() ||
            $action->getModalContentFooter();// ||
            // $action->getInfolist() ||
            // $this->mountedTableActionHasForm();
    }

    public function mountedTableActionHasForm(): bool
    {
        return (bool) count($this->getMountedTableActionForm()?->getComponents() ?? []);
    }

    public function getMountedTableAction(): ?Action
    {
        if (!count($this->mountedTableActions ?? [])) {
            return null;
        }

        return $this->getTable()->getAction($this->mountedTableActions);
    }

    public function getMountedTableActionForm(): ?Form
    {
        // @todo
        return null;
        
        $action = $this->getMountedTableAction();

        if (!$action) {
            return null;
        }

        if ((!$this->isCachingForms) && $this->hasCachedForm('mountedTableActionForm')) {
            return $this->getForm('mountedTableActionForm');
        }

        return $action->getForm(
            $this->makeForm()
                ->model($this->getMountedTableActionRecord() ?? $this->getTable()->getModel())
                ->statePath('mountedTableActionsData.' . array_key_last($this->mountedTableActionsData))
                ->operation(implode('.', $this->mountedTableActions)),
        );
    }

    public function getMountedTableActionRecordKey(): int | string | null
    {
        return $this->mountedTableActionRecord;
    }

    public function getMountedTableActionRecord(): ?Entry
    {
        $recordKey = $this->getMountedTableActionRecordKey();

        if ($this->cachedMountedTableActionRecord && ($this->cachedMountedTableActionRecordKey === $recordKey)) {
            return $this->cachedMountedTableActionRecord;
        }

        $this->cachedMountedTableActionRecordKey = $recordKey;

        if (($entries = $this->getTableEntries()) instanceof LengthAwarePaginator) {
            $entry = $entries->first(fn ($entry) => $entry->id == $recordKey);
        } else {
            $entry = $entries->get($recordKey);
        }

        return $this->cachedMountedTableActionRecord = $entry;
    }

    protected function popMountedTableAction(): ?string
    {
        try {
            return array_pop($this->mountedTableActions);
        } finally {
            array_pop($this->mountedTableActionsData);
        }
    }

    protected function resetMountedTableActionProperties(): void
    {
        $this->mountedTableActions = [];
        $this->mountedTableActionsData = [];
    }

    public function unmountTableAction(bool $shouldCancelParentActions = true): void
    {
        $action = $this->getMountedTableAction();

        if (!($shouldCancelParentActions && $action)) {
            $this->popMountedTableAction();
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

        if (!count($this->mountedTableActions)) {
            $this->closeTableActionModal($action);

            $action?->entry(null);
            // @todo 
            // $this->mountedTableActionRecord(null);

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

    protected function closeTableActionModal(Action $action): void
    {
        $this->dispatch('close-modal', id: "{$action->getId()}-table-action");
    }

    protected function openTableActionModal(Action $action): void
    {
        // $this->dispatch('open-modal', id: "{$action->getId()}-table-action");
        $this->dispatch('open-modal', id: "{$action->getId()}-action");
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
}
