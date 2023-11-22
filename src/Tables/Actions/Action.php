<?php

namespace Streams\Ui\Tables\Actions;

use Streams\Ui\Tables\Concerns\HasTable;
use Streams\Ui\Support\Concerns\HasEntry;

class Action extends \Streams\Ui\Actions\Action
{
    use HasTable;
    use HasEntry;

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            //'stream' => [$this->getStream()],
            'entry' => [$this->getEntry()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
