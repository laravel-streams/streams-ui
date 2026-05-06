<?php

namespace Streams\Ui\Builders\Tables\Actions;

use Streams\Ui\Builders\Concerns as Common;
use Streams\Ui\Builders\Actions\MountableAction;

class Action extends MountableAction
{
    use Common\HasEntry;

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
