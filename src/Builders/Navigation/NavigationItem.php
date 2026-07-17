<?php

namespace Streams\Ui\Builders\Navigation;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\Concerns as Common;

class NavigationItem extends Builder
{
    use Common\CanBeDisabled;
    use Common\CanBeHidden;
    use Common\HasBadge;
    use Common\HasHtmlAttributes;
    use Common\HasIcon;
    use Common\HasIconPosition;
    use Common\HasLabel;
    use Common\HasSortOrder;
    use Common\HasUrl;
    use Traits\CanBeActive;
    use Traits\HasActiveIcon;
    use Traits\HasGroup;

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
