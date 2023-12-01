<?php

namespace Streams\Ui\Inputs\Concerns;

use Illuminate\Support\Arr;
use Streams\Ui\Actions\Action;

trait HasHint
{
    protected string | \Closure | null $hint = null;

    protected ?array $cachedHintActions = null;

    protected array $hintActions = [];

    protected string | array | \Closure | null $hintColor = null;

    protected string | \Closure | null $hintIcon = null;

    protected string | \Closure | null $hintIconTooltip = null;

    public function hint(string | \Closure | null $hint): static
    {
        $this->hint = $hint;

        return $this;
    }

    public function hintColor(string | array | \Closure | null $color): static
    {
        $this->hintColor = $color;

        return $this;
    }

    public function hintIcon(
        string | \Closure | null $icon,
        string | \Closure | null $tooltip = null
    ): static {

        $this->hintIcon = $icon;

        $this->hintIconTooltip($tooltip);

        return $this;
    }

    public function hintIconTooltip(string | \Closure | null $tooltip): static
    {
        $this->hintIconTooltip = $tooltip;

        return $this;
    }

    public function hintAction(Action | \Closure $action): static
    {
        $this->hintActions([$action]);

        return $this;
    }

    public function hintActions(array $actions): static
    {
        $this->hintActions = [
            ...$this->hintActions,
            ...$actions,
        ];

        return $this;
    }

    public function getHint(): string | null
    {
        return $this->evaluate($this->hint);
    }

    public function getHintColor(): string | array | null
    {
        return $this->evaluate($this->hintColor);
    }

    public function getHintIcon(): ?string
    {
        return $this->evaluate($this->hintIcon);
    }

    public function getHintIconTooltip(): ?string
    {
        return $this->evaluate($this->hintIconTooltip);
    }

    public function getHintActions(): array
    {
        return $this->cachedHintActions ?? $this->cacheHintActions();
    }

    public function cacheHintActions(): array
    {
        $this->cachedHintActions = [];

        foreach ($this->hintActions as $hintAction) {
            foreach (Arr::wrap($this->evaluate($hintAction)) as $action) {
                $this->cachedHintActions[$action->getName()] = $this->prepareAction(
                    $action
                        ->defaultSize('sm')
                        ->defaultView('ui::actions.link'),
                );
            }
        }

        return $this->cachedHintActions;
    }
}
