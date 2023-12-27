<?php

namespace Streams\Ui\Builders\Tables\Concerns;

trait HasBulkActions
{
    protected array $bulkActions = [];

    //protected array $flatActions = [];

    // protected string | \Closure | null $bulkActionsColumnLabel = null;

    // protected string | \Closure | null $bulkActionsAlignment = null;

    //protected ActionsPosition | \Closure | null $bulkActionsPosition = null;

    public function bulkActions(
        array $bulkActions
        //ActionsPosition | string | \Closure | null $position = null
    ): static {

        $this->bulkActions = [
            ...$this->bulkActions,
            ...$bulkActions,
        ];

        //$this->pushActions($bulkActions);

        // if ($position) {
        //     $this->bulkActionsPosition($position);
        // }

        return $this;
    }

    // public function pushActions(array | ActionGroup $bulkActions): static
    // {
    //     foreach (Arr::wrap($bulkActions) as $action) {
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
    //             throw new InvalidArgumentException('Table bulkActions must be an instance of ' . Action::class . ' or ' . ActionGroup::class . '.');
    //         }

    //         $this->bulkActions[] = $action;
    //     }

    //     return $this;
    // }

    // public function bulkActionsColumnLabel(string | \Closure | null $label): static
    // {
    //     $this->bulkActionsColumnLabel = $label;

    //     return $this;
    // }

    // public function bulkActionsAlignment(string | \Closure | null $alignment = null): static
    // {
    //     $this->bulkActionsAlignment = $alignment;

    //     return $this;
    // }

    // public function bulkActionsPosition(ActionsPosition | \Closure | null $position = null): static
    // {
    //     $this->bulkActionsPosition = $position;

    //     return $this;
    // }

    public function getBulkActions(): array
    {
        return $this->bulkActions;
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

    public function hasBulkAction(string $name): bool
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
    //     $position = $this->evaluate($this->bulkActionsPosition);

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
    //     return $this->evaluate($this->bulkActionsAlignment);
    // }

    // public function getActionsColumnLabel(): ?string
    // {
    //     return $this->evaluate($this->bulkActionsColumnLabel);
    // }
}
