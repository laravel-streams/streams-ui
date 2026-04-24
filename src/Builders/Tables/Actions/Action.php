<?php

namespace Streams\Ui\Builders\Tables\Actions;

use Streams\Ui\Builders\Concerns as Common;

class Action extends \Streams\Ui\Builders\Actions\MountableAction
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
