<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Traits\Tappable;
use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Support\Traits\Conditionable;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Component
{
    use Tappable;
    use HasMemory;
    use Conditionable;
    use FiresCallbacks;

    public function evaluate(mixed $value)
    {
        if (!$value instanceof \Closure) {
            return $value;
        }

        return App::call($value);
    }
}
