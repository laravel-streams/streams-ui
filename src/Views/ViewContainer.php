<?php

namespace Streams\Ui\Views;

use Streams\Ui\Support\Concerns\HasComponents;
use Streams\Ui\Views\Concerns\BelongsToContainer;
use Streams\Ui\Support\Concerns\HasHtmlAttributes;
use Streams\Ui\Support\Concerns\HasAlpineAttributes;

class ViewContainer extends ViewComponent
{
    use HasComponents;

    use BelongsToContainer;

    use HasHtmlAttributes;
    use HasAlpineAttributes;
}
