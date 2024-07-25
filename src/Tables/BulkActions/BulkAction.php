<?php

namespace Streams\Ui\Tables\BulkActions;

use Streams\Ui\Tables\Concerns\BelongsToTable;

class BulkAction extends \Streams\Ui\Actions\Action
{
    use BelongsToTable;

    use Concerns\InteractsWithRecords;

    protected function setUp(): void
    {
        parent::setUp();

        $this->htmlAttributes([
            // 'x-bind:disabled' => '! selectedRecords.length',
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

    // public function getLivewireCallMountedActionName(): string
    // {
    //     return 'callMountedTableBulkAction';
    // }

    // public function getAlpineClickHandler(): ?string
    // {
    //     return "mountBulkAction('{$this->getName()}')";
    // }

    // public function getLivewireTarget(): ?string
    // {
    //     return "mountTableBulkAction('{$this->getName()}')";
    // }

    protected function resolveDefaultClosureDependency(string $parameterName): array
    {
        return match ($parameterName) {
            'records' => [$this->getRecords()],
            'table' => [$this->getTable()],
            default => parent::resolveDefaultClosureDependency($parameterName),
        };
    }
    // protected function resolveDefaultClosureDependencyForEvaluationByName(string $parameterName): array
    // {
    //     return match ($parameterName) {
    //         'records' => [$this->getRecords()],
    //         'table' => [$this->getTable()],
    //         default => parent::resolveDefaultClosureDependencyForEvaluationByName($parameterName),
    //     };
    // }
}
