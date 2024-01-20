<?php

namespace Streams\Ui\Containers;

use Streams\Ui\Traits as Support;
use Streams\Ui\Builders\ViewBuilder;

class Container extends ViewBuilder
{
    use Support\HasId;
    use Support\HasEntry;
    use Support\HasState;
    use Support\HasComponents;
    use Support\HasHtmlAttributes;
    
    use Support\CanSpanColumns;
    
    use Support\BelongsToParent;
    use Support\BelongsToLivewire;
    
    use Traits\HasColumns;

    protected string $view = 'ui::builders.container';
}
