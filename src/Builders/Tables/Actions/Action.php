<?php

namespace Streams\Ui\Builders\Tables\Actions;

use Streams\Ui\Builders\Tables\Concerns\HasTable;
use Streams\Ui\Builders\Concerns\HasEntry;

class Action extends \Streams\Ui\Actions\Action
{
    use HasTable;
    use HasEntry;

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
