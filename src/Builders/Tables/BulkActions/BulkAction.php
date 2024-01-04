<?php

namespace Streams\Ui\Builders\Tables\BulkActions;

use Streams\Ui\Builders\Tables\Concerns\BelongsToTable;

class BulkAction extends \Streams\Ui\Builders\Actions\Action
{
    use BelongsToTable;

    use Concerns\InteractsWithRecords;

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
