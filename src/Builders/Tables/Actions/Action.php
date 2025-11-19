<?php

namespace Streams\Ui\Builders\Tables\Actions;

use Streams\Ui\Builders\Concerns as Common;
use Streams\Ui\Livewire\Tables\InteractsWithTable;

class Action extends \Streams\Ui\Builders\Actions\Action
{
    use Common\HasEntry;
    
    use InteractsWithTable;

    protected function resolveDefaultClosureDependency(string $parameter): array
    {
        return match ($parameter) {
            'entry' => [$this->getEntryInstance()],
            default => parent::resolveDefaultClosureDependency($parameter),
        };
    }
}
