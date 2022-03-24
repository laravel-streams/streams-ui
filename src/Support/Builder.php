<?php

namespace Streams\Ui\Support;

use Streams\Ui\Support\Component;
use Illuminate\Support\Collection;
use Streams\Core\Support\Workflow;

class Builder extends Workflow
{
    public array $steps = [
        'load_attributes' => self::class . '@loadAttributes',
    ];

    public function loadAttributes(Component $component, Collection $attributes)
    {
        $component->loadPrototypeAttributes($attributes->all());
    }
}
