<?php

namespace Streams\Ui\Tables\Concerns;

trait HasActions
{
    protected array $actions = [];

    //protected array $flatActions = [];

    // protected string | \Closure | null $actionsColumnLabel = null;

    // protected string | \Closure | null $actionsAlignment = null;

    //protected ActionsPosition | \Closure | null $actionsPosition = null;

    public function actions(
        array $actions
        //ActionsPosition | string | \Closure | null $position = null
    ): static {

        $this->actions = [
            ...$this->actions,
            ...$actions,
        ];

        //$this->pushActions($actions);

        // if ($position) {
        //     $this->actionsPosition($position);
        // }

        return $this;
    }

    // public function pushActions(array | ActionGroup $actions): static
    // {
    //     foreach (Arr::wrap($actions) as $action) {
    //         $action->table($this);

    //         if ($action instanceof ActionGroup) {
    //             /** @var array<string, Action> $flatActions */
    //             $flatActions = $action->getFlatActions();

    //             if (!$action->getDropdownPlacement()) {
    //                 $action->dropdownPlacement('bottom-end');
    //             }

    //             $this->mergeCachedFlatActions($flatActions);
    //         } elseif ($action instanceof Action) {
    //             $action->defaultSize(ActionSize::Small);
    //             $action->defaultView($action::LINK_VIEW);

    //             $this->cacheAction($action);
    //         } else {
    //             throw new InvalidArgumentException('Table actions must be an instance of ' . Action::class . ' or ' . ActionGroup::class . '.');
    //         }

    //         $this->actions[] = $action;
    //     }

    //     return $this;
    // }

    // public function actionsColumnLabel(string | \Closure | null $label): static
    // {
    //     $this->actionsColumnLabel = $label;

    //     return $this;
    // }

    // public function actionsAlignment(string | \Closure | null $alignment = null): static
    // {
    //     $this->actionsAlignment = $alignment;

    //     return $this;
    // }

    // public function actionsPosition(ActionsPosition | \Closure | null $position = null): static
    // {
    //     $this->actionsPosition = $position;

    //     return $this;
    // }

    public function getActions(): array
    {
        return $this->actions;
    }

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

    //     $mountedRecord = $this->getLivewire()->getMountedTableActionRecord();

    //     $action = $this->getFlatActions()[$name] ?? null;

    //     if (!$action) {
    //         return null;
    //     }

    //     return $this->getMountableModalActionFromAction(
    //         $action->record($mountedRecord),
    //         modalActionNames: $modalActionNames ?? [],
    //         parentActionName: $name,
    //         mountedRecord: $mountedRecord,
    //     );
    // }

    public function hasAction(string $name): bool
    {
        return array_key_exists($name, $this->getFlatActions());
    }

    // protected function getMountableModalActionFromAction(Action $action, array $modalActionNames, string $parentActionName, ?Model $mountedRecord = null): ?Action
    // {
    //     foreach ($modalActionNames as $modalActionName) {
    //         $action = $action->getMountableModalAction($modalActionName);

    //         if (!$action) {
    //             return null;
    //         }

    //         if ($action instanceof Action) {
    //             $action->record($mountedRecord);
    //         }

    //         $parentActionName = $modalActionName;
    //     }

    //     if (!$action instanceof Action) {
    //         return null;
    //     }

    //     return $action;
    // }

    // public function getActionsPosition(): ActionsPosition
    // {
    //     $position = $this->evaluate($this->actionsPosition);

    //     if ($position) {
    //         return $position;
    //     }

    //     if (!($this->getContentGrid() || $this->hasColumnsLayout())) {
    //         return ActionsPosition::AfterColumns;
    //     }

    //     return ActionsPosition::AfterContent;
    // }

    // public function getActionsAlignment(): ?string
    // {
    //     return $this->evaluate($this->actionsAlignment);
    // }

    // public function getActionsColumnLabel(): ?string
    // {
    //     return $this->evaluate($this->actionsColumnLabel);
    // }
}
