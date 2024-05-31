<?php

namespace Streams\Ui\Forms\Layouts;

use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\ViewBuilder;

class Header extends ViewBuilder
{
    use Common\HasId;
    use Common\HasTitle;
    use Common\HasDescription;
    use Common\HasHtmlAttributes;

    use Common\BelongsToParent;
    use Common\BelongsToLivewire;

    protected string $view = 'ui::components.header';

    public function __construct(string | array | \Closure | null $title = null)
    {
        $this->title($title);
    }

    public static function make(string | array | \Closure | null $title = null): static
    {
        $static = app(static::class, ['title' => $title]);

        $static->configure();

        return $static;
    }
}
