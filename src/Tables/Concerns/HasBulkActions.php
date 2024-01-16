<?php

namespace Streams\Ui\Tables\Concerns;

use Illuminate\Support\Arr;
use Streams\Core\Entry\Entry;
use Streams\Ui\Actions\ActionGroup;
use Streams\Ui\Tables\BulkActions\BulkAction;
use Streams\Ui\Tables\BulkActions\BulkActionGroup;

trait HasBulkActions
{
    protected array $bulkActions = [];

    protected array $flatBulkActions = [];

    // protected ?\Closure $checkIfRecordIsSelectableUsing = null;

    // protected bool | \Closure | null $selectsCurrentPageOnly = false;

    // protected RecordCheckboxPosition | \Closure | null $recordCheckboxPosition = null;

    public function bulkActions(array | ActionGroup $actions): static
    {
        $this->bulkActions = [];

        $this->pushBulkActions($actions);

        return $this;
    }

    public function pushBulkActions(array | ActionGroup $actions): static
    {
        foreach (Arr::wrap($actions) as $action) {

            $action->table($this);

            if ($action instanceof ActionGroup) {

                $flatActions = $action->getFlatActions();

                $this->mergeCachedFlatBulkActions($flatActions);
            } elseif ($action instanceof BulkAction) {
                $this->cacheBulkAction($action);
            } else {
                throw new \Exception('Table bulk actions must be an instance of ' . BulkAction::class . ' or ' . ActionGroup::class . '.');
            }

            $this->bulkActions[] = $action;
        }

        return $this;
    }

    public function groupedBulkActions(array $actions): static
    {
        $this->bulkActions([BulkActionGroup::make($actions)]);

        return $this;
    }

    protected function cacheBulkAction(BulkAction $action): void
    {
        $this->flatBulkActions[$action->getName()] = $action;
    }

    protected function mergeCachedFlatBulkActions(array $actions): void
    {
        $this->flatBulkActions = [
            ...$this->flatBulkActions,
            ...$actions,
        ];
    }

    public function checkIfRecordIsSelectableUsing(?\Closure $callback): static
    {
        $this->checkIfRecordIsSelectableUsing = $callback;

        return $this;
    }

    public function selectCurrentPageOnly(bool | \Closure $condition = true): static
    {
        $this->selectsCurrentPageOnly = $condition;

        return $this;
    }

    public function getBulkActions(): array
    {
        return $this->bulkActions;
    }

    public function getFlatBulkActions(): array
    {
        return $this->flatBulkActions;
    }

    public function getBulkAction(string $name): ?BulkAction
    {
        $action = $this->getFlatBulkActions()[$name] ?? null;

        $action?->records($this->getLivewire()->getSelectedTableRecords(...));

        return $action;
    }

    public function isRecordSelectable(Entry $record): bool
    {
        return (bool) ($this->evaluate(
            $this->checkIfRecordIsSelectableUsing,
            namedInjections: [
                'record' => $record,
            ],
            typedInjections: [
                Entry::class => $record,
                $record::class => $record,
            ],
        ) ?? true);
    }

    public function getAllSelectableRecordsCount(): int
    {
        return $this->getLivewire()->getAllSelectableTableRecordsCount();
    }

    public function isSelectionEnabled(): bool
    {
        return (bool) count(array_filter(
            $this->getFlatBulkActions(),
            fn (BulkAction $action): bool => $action->isVisible(),
        ));
    }

    public function selectsCurrentPageOnly(): bool
    {
        return (bool) $this->evaluate($this->selectsCurrentPageOnly);
    }

    public function checksIfRecordIsSelectable(): bool
    {
        return $this->checkIfRecordIsSelectableUsing !== null;
    }

    public function recordCheckboxPosition(RecordCheckboxPosition | \Closure | null $position = null): static
    {
        $this->recordCheckboxPosition = $position;

        return $this;
    }

    public function getRecordCheckboxPosition(): RecordCheckboxPosition
    {
        return $this->evaluate($this->recordCheckboxPosition) ?? RecordCheckboxPosition::BeforeCells;
    }
}
