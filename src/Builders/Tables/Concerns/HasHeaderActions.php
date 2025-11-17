<?php

namespace Streams\Ui\Builders\Tables\Concerns;

trait HasHeaderActions
{
    protected array $headerActions = [];

    //protected array $flatActions = [];

    // protected string | \Closure | null $headerActionsColumnLabel = null;

    // protected string | \Closure | null $headerActionsAlignment = null;

    //protected ActionsPosition | \Closure | null $headerActionsPosition = null;

    public function headerActions(
        array $headerActions
        //ActionsPosition | string | \Closure | null $position = null
    ): static {

        $this->headerActions = [
            ...$this->headerActions,
            ...$headerActions,
        ];

        //$this->pushActions($headerActions);

        // if ($position) {
        //     $this->headerActionsPosition($position);
        // }

        return $this;
    }

    // public function pushActions(array | ActionGroup $headerActions): static
    // {
    //     foreach (Arr::wrap($headerActions) as $action) {
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
    //             throw new InvalidArgumentException('Table headerActions must be an instance of ' . Action::class . ' or ' . ActionGroup::class . '.');
    //         }

    //         $this->headerActions[] = $action;
    //     }

    //     return $this;
    // }

    // public function headerActionsColumnLabel(string | \Closure | null $label): static
    // {
    //     $this->headerActionsColumnLabel = $label;

    //     return $this;
    // }

    // public function headerActionsAlignment(string | \Closure | null $alignment = null): static
    // {
    //     $this->headerActionsAlignment = $alignment;

    //     return $this;
    // }

    // public function headerActionsPosition(ActionsPosition | \Closure | null $position = null): static
    // {
    //     $this->headerActionsPosition = $position;

    //     return $this;
    // }

    public function getHeaderActions(): array
    {
        return $this->headerActions;
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

    public function hasHeaderAction(string $name): bool
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
    //     $position = $this->evaluate($this->headerActionsPosition);

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
    //     return $this->evaluate($this->headerActionsAlignment);
    // }

    // public function getActionsColumnLabel(): ?string
    // {
    //     return $this->evaluate($this->headerActionsColumnLabel);
    // }
}
