<?php

namespace Streams\Ui\Support;

use Streams\Core\Support\Traits\HasMemory;
use Streams\Core\Support\Traits\FiresCallbacks;

abstract class Component
{
    use HasMemory;
    use FiresCallbacks;
}
