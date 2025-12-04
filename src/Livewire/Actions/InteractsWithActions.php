<?php

namespace Streams\Ui\Livewire\Actions;

use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;
use Streams\Ui\Exceptions\Halt;
use Streams\Ui\Exceptions\Cancel;
use Streams\Ui\Builders\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Streams\Ui\Builders\Actions\Action;
use Streams\Ui\Builders\Actions\MountableAction;
use Streams\Ui\Support\Facades\Actions;

trait InteractsWithActions
{
    public ?array $mountedActions = [];

    public ?array $mountedActionsArguments = [];

    public ?array $mountedActionsData = [];

    protected ?array $cachedActions = null;

    public function callMountedAction(array|string $arguments = []): mixed
    {
        $action = $this->getMountedAction();

        if (! $action) {
            return null;
        }

        if ($action->isDisabled()) {
            return null;
        }

        $action->arguments([
            ...Arr::last($this->mountedActionsArguments),
            ...(array) $arguments,
        ]);

        $form = $this->getMountedActionForm();

        $result = null;

        // $originallyMountedActions = $this->mountedActions;

        // try {
        if ($this->mountedActionHasForm()) {
            //         $action->callBeforeFormValidated();

            // $action->formData((array) $form->getState());
            $action->formData((array) $this->data);

            //         $action->callAfterFormValidated();
        }

        $action->fire('before_call', [
            'action' => $action,
            'component' => $this,
            'arguments' => (array) $arguments,
        ]);

        $result = $action->call([
            'action' => $action,
            'component' => $this,
            'livewire' => $this,
            'arguments' => (array) $arguments,
        ]);

        $action->fire('after_call');

        // } catch (Halt $exception) {
        //     return null;
        // } catch (Cancel $exception) {
        // } catch (ValidationException $exception) {

        if (! $this->mountedActionShouldOpenModal()) {

            $action->resetArguments();
            // $action->resetFormData();

            $this->unmountAction();
        }

        //     throw $exception;
        // }

        // if (store($this)->has('redirect')) {
        //     return $result;
        // }

        $action->resetArguments();
        // $action->resetFormData();

        // If the action was replaced while it was being called,
        // we don't want to unmount it.
        // if ($originallyMountedActions !== $this->mountedActions) {
        //     $action->clearRecordAfter();

        //     return null;
        // }

        $this->unmountAction();

        return $result;
    }

    public function mountAction(string $name, array $arguments = []): mixed
    {
        $this->mountedActions[] = $name;
        $this->mountedActionsArguments[] = $arguments;
        $this->mountedActionsData[] = [];

        $action = $this->getMountedAction();

        if (! $action) {

            $this->unmountAction();

            return null;
        }

        if ($action->isDisabled()) {

            $this->unmountAction();

            return null;
        }

        $action->arguments($arguments);

        // $this->cacheMountedActionForm();

        try {
            $hasForm = $this->mountedActionHasForm();

            // if ($hasForm) {
            //     $action->callBeforeFormFilled();
            // }

            $action->form($this->getMountedActionForm());

            if ($hasForm) {
                $action->fire('form_filled', [
                    'action' => $action,
                    'component' => $this,
                    'livewire' => $this,
                    'entry' => $this->getMountedAction()->getEntryInstance(),
                ]);
            }
        } catch (Halt $exception) {
            return null;
        } catch (Cancel $exception) {

            $this->unmountAction();

            return null;
        }

        if (! $this->mountedActionShouldOpenModal()) {
            return $this->callMountedAction();
        }

        $this->resetErrorBag();

        $this->openActionModal($action);

        return null;
    }

    /**
     * @param  array<string, mixed>  $arguments
     */
    public function replaceMountedAction(string $name, array $arguments = []): void
    {
        $this->mountedActions = [];
        $this->mountedActionsArguments = [];
        $this->mountedActionsData = [];

        $this->mountAction($name, $arguments);
    }

    public function mountedActionShouldOpenModal(): bool
    {
        $action = $this->getMountedAction() ?: $this->getMountedTableAction();

        if (! $action) {
            return false;
        }

        if ($action->isModalHidden()) {
            return false;
        }

        return $action->getModalHeading() ||
            $action->getModalDescription() ||
            $action->getModalComponents() ||
            $action->getModalContent() ||
            $action->getModalContentFooter();
    }

    public function mountedActionHasForm(): bool
    {
        return (bool) count($this->getMountedActionForm()?->getComponents() ?? []);
    }

    public function cacheActions(): ?array
    {
        $registered = Actions::all();

        $actions = $this->getMountableActions();

        foreach ($actions + $registered as $action) {
            
            if ($action instanceof MountableAction) {
                $action->livewire($this);
            }

            $this->cachedActions[$action->getName()] = $action;
        }

        return $this->cachedActions;
    }

    /**
     * @param  array<string, Action>  $actions
     */
    protected function mergeCachedActions(array $actions): void
    {
        $this->cachedActions = [
            ...$this->cachedActions,
            ...$actions,
        ];
    }

    protected function configureAction(Action $action): void {}

    public function getMountedAction(): ?Action
    {
        if (! count($this->mountedActions ?? [])) {
            return null;
        }

        return $this->getAction(end($this->mountedActions));
    }

    public function getMountedActionForm(): ?Form
    {
        $action = $this->getMountedAction();

        if (! $action) {
            return null;
        }

        // if ((!$this->isCachingForms) && $this->hasCachedForm('mountedActionForm')) {
        //     return $this->getForm('mountedActionForm');
        // }

        return $action->getForm();
        // return $action->getForm(
        //     $this->makeForm()
        //         ->statePath('mountedActionsData.' . array_key_last($this->mountedActionsData))
        //         ->model($action->getEntry() ?? $action->getModel() ?? $this->getMountedActionFormModel())
        //         ->operation(implode('.', $this->mountedActions)),
        // );
    }

    public function getAction(string $name): ?Action
    {
        if ($this->cachedActions === null) {
            $this->cachedActions = $this->cacheActions();
        }

        $action = $this->cachedActions[$name] ?? null;

        if (! $action) {
            throw new \InvalidArgumentException("No action named [{$name}] found in the Livewire component.");
        }

        return $action;
    }

    public function unmountAction(): void
    {
        if (! $action = $this->getMountedAction()) {
            return;
        }

        if (($key = array_search($action->getName(), $this->mountedActions)) !== false) {
            array_splice($this->mountedActions, $key, 1);
        }

        if (! count($this->mountedActions)) {
            $this->closeActionModal();

            // $action?->clearRecordAfter();

            return;
        }

        // $this->cacheMountedActionForm();

        $this->resetErrorBag();

        $this->closeActionModal($action);
    }

    protected function closeActionModal(): void
    {
        $this->dispatch('close-modal');
        // $this->dispatch('close-modal', id: "{$this->getId()}-action");
    }

    protected function openActionModal(Action $action): void
    {
        $this->dispatch('open-modal');
        // $this->dispatch('open-modal', id: "{$action->getId()}-action");
    }
}
