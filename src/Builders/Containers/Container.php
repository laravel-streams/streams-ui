<?php

namespace Streams\Ui\Builders\Containers;

use Illuminate\Support\Str;
use Streams\Ui\Traits as Support;
use Streams\Ui\Builders\ViewBuilder;

class Container extends ViewBuilder
{
    use Support\HasId;
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
    }

    public static function make(?string $id = null): static
    {
        $static = app(static::class, ['id' => $id ?: Str::random(10)]);

        $static->configure();

        return $static;
    }
}
