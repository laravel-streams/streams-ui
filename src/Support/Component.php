<?php

namespace Streams\Ui\Support;

use Illuminate\Support\Traits\Tappable;
use Streams\Ui\Support\Concerns\HasView;
use Illuminate\Contracts\Support\Htmlable;
use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Support\Traits\Conditionable;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Ui\Support\Concerns\EvaluatesClosures;

abstract class Component implements Htmlable
{
    use HasView;
    use Tappable;
    use HasMemory;
    use Conditionable;
    use FiresCallbacks;
    use EvaluatesClosures;
}
