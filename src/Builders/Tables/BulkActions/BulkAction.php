<?php

namespace Streams\Ui\Builders\Tables\BulkActions;

use Streams\Ui\Builders\Actions\MountableAction;
use Streams\Ui\Builders\Tables\Concerns\BelongsToTable;

class BulkAction extends MountableAction
{
    use BelongsToTable;
    use Concerns\InteractsWithRecords;

    protected function setUp(): void
    {
        parent::setUp();

        $name = $this->getName();

        $this->mergeHtmlAttributes([
            'x-on:click.stop' => "mountBulkAction('{$name}')",
        ]);
    }

    /**
     * Alpine confirm-then-mount expression safe for HTML attribute serialization.
     *
     * ComponentAttributeBag only backslash-escapes quotes (`\"`), which HTML still
     * treats as attribute terminators. Pre-encode confirm() JSON as HTML entities
     * (`&quot;`) so the attribute value stays one intact string.
     */
    public function confirmThenMountExpression(string $message): string
    {
        $confirm = htmlspecialchars(
            json_encode($message, JSON_THROW_ON_ERROR),
            ENT_QUOTES,
            'UTF-8',
            double_encode: false,
        );

        $name = $this->getName();

        return "if (confirm({$confirm})) mountBulkAction('{$name}')";
    }

    public function call(array $parameters = []): mixed
    {
        return $this->evaluate($this->getAction(), $parameters);
    }

    public function getAction(): ?\Closure
    {
        $action = $this->action;

        if (is_string($action)) {
            $action = \Closure::fromCallable([$this->getLivewire(), $action]);
        }

        return $action;
    }

    protected function resolveDefaultClosureDependency(string $parameterName): array
    {
        return match ($parameterName) {
            'records' => [$this->getRecords()],
            // selectedEntries must be injected by HasBulkActions::callMountedTableBulkAction
            // (paged matching snapshots). Do not re-read Livewire page checkboxes here.
            'selectedEntries' => [[]],
            'table' => [$this->getTable()],
            default => parent::resolveDefaultClosureDependency($parameterName),
        };
    }
}
