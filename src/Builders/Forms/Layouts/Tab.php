<?php

namespace Streams\Ui\Builders\Forms\Layouts;

use Illuminate\Support\Str;
use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\ViewBuilder;

class Tab extends ViewBuilder
{
    use Common\HasBadge;
    use Common\HasComponents;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasIconPosition;
    use Common\HasId;
    use Common\HasLabel;

    protected string $view = 'ui::components.tabs.tab';

    final public function __construct(string $label)
    {
        $this->label($label);

        $this->id(Str::slug($label));
    }

    public static function make(string $label): static
    {
        $static = app(static::class, ['label' => $label]);

        $static->configure();

        return $static;
    }
}
