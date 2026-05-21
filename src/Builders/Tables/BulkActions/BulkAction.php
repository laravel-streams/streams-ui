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

    public function call(array $parameters = []): mixed
    {
        try {
            // return $this->evaluate($this->getActionFunction(), $parameters);
            return $this->evaluate($this->getAction(), $parameters);
        } catch (\Exception $e) {
            dump($e->getMessage());
            // if ($this->shouldDeselectRecordsAfterCompletion()) {
            //     $this->getLivewire()->deselectAllTableRecords();
            // }
        }
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
            'selectedEntries' => [$this->getLivewire()->getSelectedTableEntries($this->getTable()->getName())],
            'table' => [$this->getTable()],
            default => parent::resolveDefaultClosureDependency($parameterName),
        };
    }
}
