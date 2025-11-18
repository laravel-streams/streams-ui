<?php

namespace Streams\Ui\Builders\Navigation;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\Navigation;

class NavigationItem extends Builder
{
    use Common\CanBeDisabled;
    use Common\CanBeHidden;
    use Common\HasBadge;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasLabel;
    use Common\HasSort;
    use Common\HasUrl;
    use Navigation\Traits\CanBeActive;
    use Navigation\Traits\HasActiveIcon;
    use Navigation\Traits\HasGroup;

    final public function __construct(string|\Closure|null $label = null)
    {
        if (filled($label)) {
            $this->label($label);
        }
    }

    public static function make(string|\Closure|null $label = null): static
    {
        $instance = app(static::class, [
            'label' => $label,
        ]);

        $instance->configure();

        return $instance;
    }
}
