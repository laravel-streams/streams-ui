<?php

namespace Streams\Ui\Builders;

use Streams\Ui\Builders\Concerns;
use Illuminate\Support\Traits as Laravel;
use Streams\Core\Support\Traits as Streams;

abstract class Builder
{
    use Laravel\Tappable;
    use Laravel\Conditionable;
    
    use Streams\HasMemory;
    use Streams\FiresCallbacks;

    use Concerns\CanBeConfigured;
    use Concerns\CanBeAuthorized;
    use Concerns\EvaluatesClosures;
}
