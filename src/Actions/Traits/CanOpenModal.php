<?php

namespace Streams\Ui\Actions\Traits;

use Illuminate\View\View;
use Streams\Ui\Actions\Action;
use Streams\Ui\Actions\MountableAction;
use Illuminate\Contracts\Support\Htmlable;

trait CanOpenModal
{
    protected array | \Closure $extraModalFooterActions = [];

    protected bool | \Closure | null $isModalFooterSticky = null;

    protected bool | \Closure | null $isModalHeaderSticky = null;


    protected array $modalActions = [];

    protected string | \Closure | null $modalAlignment = null;

    protected array | \Closure | null $modalFooterActions = null;

    protected string | \Closure | null $modalFooterActionsAlignment = null;

    protected Action | bool | \Closure | null $modalCancelAction = null;

    protected string | \Closure | null $modalCancelActionLabel = null;

    protected Action | bool | \Closure | null $modalSubmitAction = null;

    protected string | \Closure | null $modalSubmitActionLabel = null;

    protected View | Htmlable | \Closure | null $modalContent = null;

    protected View | Htmlable | \Closure | null $modalContentFooter = null;

    protected string | Htmlable | \Closure | null $modalHeading = null;

    protected string | Htmlable | \Closure | null $modalDescription = null;

    protected string | \Closure | null $modalWidth = null;

    protected bool | \Closure | null $isModalHidden = false;

    protected bool | \Closure | null $hasModalCloseButton = null;

    protected bool | \Closure | null $isModalClosedByClickingAway = null;

    protected string | \Closure | null $modalIcon = null;

    protected string | array | \Closure | null $modalIconColor = null;

    public function closeModalByClickingAway(bool | \Closure | null $condition = true): static
    {
        $this->isModalClosedByClickingAway = $condition;

        return $this;
    }

    public function modalAlignment(string | \Closure | null $alignment = null): static
    {
        $this->modalAlignment = $alignment;

        return $this;
    }

    public function modalCloseButton(bool | \Closure | null $condition = true): static
    {
        $this->hasModalCloseButton = $condition;

        return $this;
    }

    public function modalIcon(string | \Closure | null $icon = null): static
    {
        $this->modalIcon = $icon;

        return $this;
    }

    public function modalIconColor(string | array | \Closure | null $color = null): static
    {
        $this->modalIconColor = $color;

        return $this;
    }

    public function modalFooterActions(array | \Closure | null $actions = null): static
    {
        $this->modalFooterActions = $actions;

        return $this;
    }

    public function modalFooterActionsAlignment(string | \Closure | null $alignment = null): static
    {
        $this->modalFooterActionsAlignment = $alignment;

        return $this;
    }

    public function extraModalFooterActions(array | \Closure $actions): static
    {
        $this->extraModalFooterActions = $actions;

        return $this;
    }

    public function registerModalActions(array $actions): static
    {
        $this->modalActions = [
            ...$this->modalActions,
            ...$actions,
        ];

        return $this;
    }

    public function modalSubmitAction(Action | bool | \Closure | null $action = null): static
    {
        $this->modalSubmitAction = $action;

        return $this;
    }

    public function modalCancelAction(Action | bool | \Closure | null $action = null): static
    {
        $this->modalCancelAction = $action;

        return $this;
    }

    public function modalSubmitActionLabel(string | \Closure | null $label = null): static
    {
        $this->modalSubmitActionLabel = $label;

        return $this;
    }

    public function modalCancelActionLabel(string | \Closure | null $label = null): static
    {
        $this->modalCancelActionLabel = $label;

        return $this;
    }

    public function modalContent(View | Htmlable | \Closure | null $content = null): static
    {
        $this->modalContent = $content;

        return $this;
    }

    public function modalFooterContent(View | Htmlable | \Closure | null $footer = null): static
    {
        $this->modalContentFooter = $footer;

        return $this;
    }

    public function modalHeading(string | Htmlable | \Closure | null $heading = null): static
    {
        $this->modalHeading = $heading;

        return $this;
    }

    public function modalDescription(string | Htmlable | \Closure | null $description = null): static
    {
        $this->modalDescription = $description;

        return $this;
    }

    public function modalWidth(string | \Closure | null $width = null): static
    {
        $this->modalWidth = $width;

        return $this;
    }

    public function getLivewireCallMountedActionName(): ?string
    {
        return null;
    }

    public function modalHidden(bool | \Closure | null $condition = false): static
    {
        $this->isModalHidden = $condition;

        return $this;
    }

    public function getModalFooterActions(): array
    {
        // if ($this->isWizard()) {
        //     return [];
        // }

        if (isset($this->cachedModalFooterActions)) {
            return $this->cachedModalFooterActions;
        }

        if ($this->modalFooterActions) {
            $actions = [];

            foreach ($this->evaluate($this->modalFooterActions) as $action) {
                $actions[$action->getName()] = $this->prepareModalAction($action);
            }

            return $this->cachedModalFooterActions = $actions;
        }

        $actions = [];

        if ($submitAction = $this->getModalSubmitAction()) {
            $actions['submit'] = $submitAction;
        }

        $actions = [
            ...$actions,
            ...$this->getExtraModalFooterActions(),
        ];

        if ($cancelAction = $this->getModalCancelAction()) {
            $actions['cancel'] = $cancelAction;
        }

        if (in_array($this->getModalFooterActionsAlignment(), ['center'])) {
            $actions = array_reverse($actions);
        }

        return $this->cachedModalFooterActions = $actions;
    }

    public function getModalFooterActionsAlignment(): string | null
    {
        return $this->evaluate($this->modalFooterActionsAlignment);
    }

    public function getModalActions(): array
    {
        if (isset($this->cachedModalActions)) {
            return $this->cachedModalActions;
        }

        $actions = $this->getModalFooterActions();

        foreach ($this->modalActions as $action) {
            $actions[$action->getName()] = $this->prepareModalAction($action);
        }

        return $this->cachedModalActions = $actions;
    }

    public function getModalAction(string $name): ?Action
    {
        return $this->getModalActions()[$name] ?? null;
    }

    public function getMountableModalAction(string $name): ?MountableAction
    {
        $action = $this->getModalAction($name);

        if (!$action) {
            return null;
        }

        if (!$action instanceof MountableAction) {
            return null;
        }

        return $action;
    }

    public function prepareModalAction(Action $action): Action
    {
        if (!$action instanceof MountableAction) {
            return $action;
        }

        $action->livewire($this->getLivewire());

        if (
            ($this instanceof HasRecord) &&
            ($action instanceof HasRecord)
        ) {
            $action->entry($this->getEntry());
        }

        return $action;
    }

    public function getVisibleModalFooterActions(): array
    {
        return array_filter(
            $this->getModalFooterActions(),
            fn (Action $action): bool => $action->isVisible(),
        );
    }

    public function getModalSubmitAction(): ?Action
    {
        $action = static::makeModalAction('submit')
            ->label($this->getModalSubmitActionLabel())
            // ->submit($this->getLivewireCallMountedActionName())
            ->color(match ($color = $this->getColor()) {
                'gray' => 'primary',
                default => $color,
            });

        if ($this->modalSubmitAction !== null) {
            $action = $this->evaluate($this->modalSubmitAction, ['action' => $action]) ?? $action;
        }

        if ($action === false) {
            return null;
        }

        return $action;
    }

    public function getModalCancelAction(): ?Action
    {
        $action = static::makeModalAction('cancel')
            ->label($this->getModalCancelActionLabel())
            // ->close()
            ->color('gray');

        if ($this->modalCancelAction !== null) {
            $action = $this->evaluate($this->modalCancelAction, ['action' => $action]) ?? $action;
        }

        if ($action === false) {
            return null;
        }

        return $action;
    }

    public function getExtraModalFooterActions(): array
    {
        if (isset($this->cachedExtraModalFooterActions)) {
            return $this->cachedExtraModalFooterActions;
        }

        $actions = [];

        foreach ($this->evaluate($this->extraModalFooterActions) as $action) {
            $actions[$action->getName()] = $this->prepareModalAction($action);
        }

        return $this->cachedExtraModalFooterActions = $actions;
    }

    public function getModalAlignment(): string
    {
        return $this->evaluate($this->modalAlignment) ?? (in_array($this->getModalWidth(), ['xs', 'sm']) ? 'center' : 'start');
    }

    public function getModalSubmitActionLabel(): string
    {
        return $this->evaluate($this->modalSubmitActionLabel) ?? __('filament-actions::modal.actions.submit.label');
    }

    public function getModalCancelActionLabel(): string
    {
        return $this->evaluate($this->modalCancelActionLabel) ?? __('filament-actions::modal.actions.cancel.label');
    }

    public function getModalContent(): View | Htmlable | null
    {
        return $this->evaluate($this->modalContent);
    }

    public function getModalContentFooter(): View | Htmlable | null
    {
        return $this->evaluate($this->modalContentFooter);
    }

    public function getCustomModalHeading(): string | Htmlable | null
    {
        return $this->evaluate($this->modalHeading);
    }

    public function getModalHeading(): string | Htmlable | null
    {
        return $this->getCustomModalHeading();
    }

    public function getModalDescription(): string | Htmlable | null
    {
        return $this->evaluate($this->modalDescription);
    }

    public function getModalWidth(): string
    {
        return $this->evaluate($this->modalWidth) ?? '4xl';
    }

    public function isModalFooterSticky(): bool
    {
        return (bool) ($this->evaluate($this->isModalFooterSticky));
    }

    public function isModalHeaderSticky(): bool
    {
        return (bool) ($this->evaluate($this->isModalHeaderSticky));
    }

    public function isModalHidden(): bool
    {
        return (bool) $this->evaluate($this->isModalHidden);
    }

    public function hasModalCloseButton(): bool
    {
        return $this->evaluate($this->hasModalCloseButton) ?? true;
    }

    public function isModalClosedByClickingAway(): bool
    {
        return (bool) ($this->evaluate($this->isModalClosedByClickingAway) ?? true);
    }

    public function makeModalSubmitAction(string $name, ?array $arguments = null): Action
    {
        return static::makeModalAction($name)
            ->callParent($this->getLivewireCallMountedActionName())
            ->arguments($arguments)
            ->color('gray');
    }

    public function makeModalAction(string $name): Action
    {
        return Action::make($name);
    }

    public function getModalIcon(): ?string
    {
        return $this->evaluate($this->modalIcon);
    }

    public function getModalIconColor(): string | array | null
    {
        return $this->evaluate($this->modalIconColor) ?? $this->getColor() ?? 'primary';
    }

    public function stickyModalFooter(bool | \Closure $condition = true): static
    {
        $this->isModalFooterSticky = $condition;

        return $this;
    }

    public function stickyModalHeader(bool | \Closure $condition = true): static
    {
        $this->isModalHeaderSticky = $condition;

        return $this;
    }

    public function shouldOpenModal()
    {
        return $this->getModalHeading() || $this->getModalDescription() || $this->getModalContent();
    }
}
