<?php

namespace Streams\Ui\Builders;

use Illuminate\Support\Traits\Tappable;
use Streams\Core\Support\Traits\HasMemory;
use Illuminate\Support\Traits\Conditionable;
use Streams\Core\Support\Traits\FiresCallbacks;
use Streams\Ui\Builders\Concerns\CanBeConfigured;
use Streams\Ui\Builders\Concerns\EvaluatesClosures;

abstract class Builder
{
    use CanBeConfigured;
    use Conditionable;
    use EvaluatesClosures;
    use FiresCallbacks;
    use HasMemory;
    use Tappable;
}
