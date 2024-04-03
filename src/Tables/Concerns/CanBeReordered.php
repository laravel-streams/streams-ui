<?php

namespace Streams\Ui\Tables\Concerns;

use Streams\Ui\Actions\Action;

trait CanBeReordered
{
    protected bool | \Closure $reorderable = true;

    protected string | \Closure | null $reorderColumn = null;

    protected ?\Closure $reorderTriggerActionUsing = null;

    public function reorderTriggerAction(?\Closure $callback): static
    {
        $this->reorderTriggerActionUsing = $callback;

        return $this;
    }

    public function reorderable(
        string | \Closure | null $column = null,
        bool | \Closure | null $condition = null
    ): static {

        $this->reorderColumn = $column;

        if ($condition !== null) {
            $this->reorderable = $condition;
        }

        return $this;
    }

    public function getReorderTriggerAction(bool $isReordering): Action
    {
        $action = Action::make('reorderRecords')
            ->label($isReordering ? __('ui-tables::table.actions.disable_reordering.label') : __('ui-tables::table.actions.enable_reordering.label'))
            // ->iconButton()
            ->icon($isReordering ? 'heroicon-m-check' : 'heroicon-m-arrows-up-down')
            ->color('gray')
            ->action('toggleTableReordering');
        // ->table($this);

        if ($this->reorderTriggerActionUsing) {
            $action = $this->evaluate($this->reorderTriggerActionUsing, [
                'action' => $action,
                'isReordering' => $isReordering,
            ]) ?? $action;
        }

        return $action;
    }

    public function getReorderColumn(): ?string
    {
        return $this->evaluate($this->reorderColumn);
    }

    public function isReorderable(): bool
    {
        return filled($this->getReorderColumn()) && $this->evaluate($this->reorderable);
    }

    public function isReordering(): bool
    {
        return $this->getLivewire()->isTableReordering();
    }
}
