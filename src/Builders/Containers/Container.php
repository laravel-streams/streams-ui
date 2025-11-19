<?php

namespace Streams\Ui\Builders\Containers;

use Illuminate\Support\Str;
use Streams\Ui\Builders\ViewBuilder;
use Streams\Ui\Builders\Concerns as Support;

class Container extends ViewBuilder
{
    use Support\BelongsToLivewire;
    use Support\BelongsToParent;
    use Support\CanSpanColumns;
    use Support\HasComponents;
    use Support\HasHtmlAttributes;
    use Support\HasId;

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
