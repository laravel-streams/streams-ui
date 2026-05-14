<?php

namespace Streams\Ui\Builders;

use Illuminate\Support\Traits as Laravel;
use Streams\Core\Support\Traits as Streams;

abstract class Builder
{
    use Concerns\CanBeAuthorized;
    use Concerns\CanBeConfigured;
    use Concerns\EvaluatesClosures;
    use Laravel\Conditionable;
    use Laravel\Tappable;
    use Streams\FiresCallbacks;
    use Streams\HasMemory;
}
