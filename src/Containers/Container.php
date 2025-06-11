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

    protected string $viewIdentifier = 'container';

    protected string $view = 'ui::builders.container';

    public function __construct(string $id)
    {
        $this->id($id);
        $this->statePath($id);
    }

    public static function make(string $id): static
    {
        $static = app(static::class, ['id' => $id]);

        $static->configure();

        return $static;
    }
}
