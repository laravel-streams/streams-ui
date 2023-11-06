<?php

namespace Streams\Ui\Support;

use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\FiresCallbacks;

class Component extends \Livewire\Component
{
    use HasMemory;
    use FiresCallbacks;

    static public function make(array $attributes = []): static
    {
        $instance = new static;

        array_map(function ($value, $key) use ($instance) {
            $instance->{$key} = $value;
        }, $attributes, array_keys($attributes));

        return $instance;
    }
}
