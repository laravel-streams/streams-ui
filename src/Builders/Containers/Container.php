<?php

namespace Streams\Ui\Builders\Containers;

use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns\HasComponents;
use Streams\Ui\Builders\Concerns\HasHtmlAttributes;
use Streams\Ui\Builders\Concerns\HasAlpineAttributes;
use Streams\Ui\Builders\Containers\Concerns\BelongsToContainer;

class Container extends ViewBuilder
{
    use HasComponents;

    use BelongsToContainer;

    use HasHtmlAttributes;
    use HasAlpineAttributes;
}
 