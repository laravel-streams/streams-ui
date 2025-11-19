<?php

namespace Streams\Ui\Livewire\Actions;

use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;
use Streams\Ui\Exceptions\Halt;
use Streams\Ui\Exceptions\Cancel;
use Streams\Ui\Builders\Forms\Form;
use Illuminate\Database\Eloquent\Model;
use Streams\Ui\Builders\Actions\Action;

trait InteractsWithActions
{
    public ?array $mountedActions = [];

    public ?array $mountedActionsArguments = [];

    public ?array $mountedActionsData = [];

    protected array $cachedActions = [];

    protected bool $hasActionsModalRendered = false;

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

            $action->formData((array) $form->getState());

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

        //     $this->afterActionCalled();
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

    protected function afterActionCalled(): void {}

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

            $this->unmountAction(shouldCancelParentActions: false);

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
        $this->resetMountedActionProperties();
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
        // $action->getInfolist() ||
        // $this->mountedActionHasForm();
    }

    public function mountedActionHasForm(): bool
    {
        return (bool) count($this->getMountedActionForm()?->getComponents() ?? []);
    }

    public function cacheAction(Action $action): Action
    {
        $action->livewire($this);

        return $this->cachedActions[$action->getName()] = $action;
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

        return $this->getAction($this->mountedActions);
    }

    /**
     * @return array<int | string, string | Form>
     */
    protected function getInteractsWithActionsForms(): array
    {
        return [
            'mountedActionForm' => $this->getMountedActionForm(),
        ];
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

    protected function getMountedActionFormModel(): Model|Entry|string|null
    {
        return null;
    }

    /**
     * @param  string | array<string>  $name
     */
    // public function getAction(string | array $name): ?Action
    // {
    //     if (is_string($name) && str($name)->contains('.')) {
    //         $name = explode('.', $name);
    //     }

    //     if (is_array($name)) {
    //         $firstName = array_shift($name);
    //         $modalActionNames = $name;

    //         $name = $firstName;
    //     }

    //     if ($action = $this->cachedActions[$name] ?? null) {
    //         return $this->getMountableModalActionFromAction(
    //             $action,
    //             modalActionNames: $modalActionNames ?? [],
    //             parentActionName: $name,
    //         );
    //     }

    //     if (
    //         (!str($name)->endsWith('Action')) &&
    //         method_exists($this, "{$name}Action")
    //     ) {
    //         $methodName = "{$name}Action";
    //     } elseif (method_exists($this, $name)) {
    //         $methodName = $name;
    //     } else {
    //         return null;
    //     }

    //     $action = Action::configureUsing(
    //         Closure::fromCallable([$this, 'configureAction']),
    //         fn () => $this->{$methodName}(),
    //     );

    //     if (!$action instanceof Action) {
    //         throw new InvalidArgumentException('Actions must be an instance of ' . Action::class . ". The [{$methodName}] method on the Livewire component returned an instance of [" . get_class($action) . '].');
    //     }

    //     return $this->getMountableModalActionFromAction(
    //         $this->cacheAction($action),
    //         modalActionNames: $modalActionNames ?? [],
    //         parentActionName: $name,
    //     );
    // }

    /**
     * @param  array<string>  $modalActionNames
     */
    protected function getMountableModalActionFromAction(Action $action, array $modalActionNames, string $parentActionName): ?Action
    {
        foreach ($modalActionNames as $modalActionName) {
            $action = $action->getMountableModalAction($modalActionName);

            if (! $action) {
                return null;
            }

            $parentActionName = $modalActionName;
        }

        if (! $action instanceof Action) {
            return null;
        }

        return $action;
    }

    protected function popMountedAction(): ?string
    {
        try {
            return array_pop($this->mountedActions);
        } finally {
            array_pop($this->mountedActionsArguments);
            array_pop($this->mountedActionsData);
        }
    }

    protected function resetMountedActionProperties(): void
    {
        $this->mountedActions = [];
        $this->mountedActionsArguments = [];
        $this->mountedActionsData = [];
    }

    public function unmountAction(bool $shouldCancelParentActions = true): void
    {
        if (! $action = $this->getMountedAction()) {
            return;
        }

        // if (!($shouldCancelParentActions && $action)) {
        //     $this->popMountedAction();
        // } elseif ($action->shouldCancelAllParentActions()) {
        //     $this->resetMountedActionProperties();
        // } else {
        //     $parentActionToCancelTo = $action->getParentActionToCancelTo();

        //     while (true) {
        //         $recentlyClosedParentAction = $this->popMountedAction();

        //         if (
        //             blank($parentActionToCancelTo) ||
        //             ($recentlyClosedParentAction === $parentActionToCancelTo)
        //         ) {
        //             break;
        //         }
        //     }
        // }

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

    protected function cacheMountedActionForm(): void
    {
        $this->cacheForm(
            'mountedActionForm',
            fn () => $this->getMountedActionForm(),
        );
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

    public function getActiveActionsLocale(): ?string
    {
        return null;
    }

    // public function mountedActionInfolist(): Infolist
    // {
    //     return $this->getMountedAction()->getInfolist();
    // }
}
