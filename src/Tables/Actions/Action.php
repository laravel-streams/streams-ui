<?php

namespace Streams\Ui\Tables\Actions;

use Streams\Ui\Builders\Concerns\HasEntry;
use Streams\Ui\Components\Tables\InteractsWithTable;

class Action extends \Streams\Ui\Actions\Action
{
    use HasEntry;
    use InteractsWithTable;

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
