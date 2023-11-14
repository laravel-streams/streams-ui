<?php

namespace Streams\Ui\Tables\Actions;

use Streams\Ui\Tables\Concerns\HasTable;
use Streams\Ui\Support\Concerns\HasRecord;

class Action extends \Streams\Ui\Actions\Action
{
    use HasTable;
    use HasRecord;

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            //'stream' => [$this->getStream()],
            'record' => [$this->getRecord()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
