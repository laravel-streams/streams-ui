<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Traits\Tappable;
use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Support\Traits\Conditionable;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Ui\Support\Concerns\CanBeConfigured;
use Streams\Ui\Support\Concerns\EvaluatesClosures;

abstract class Component
{
    use Tappable;
    use HasMemory;
    use Conditionable;
    use FiresCallbacks;
    use CanBeConfigured;
    use EvaluatesClosures;
}
