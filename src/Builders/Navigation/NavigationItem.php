<?php

namespace Streams\Ui\Builders\Navigation;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\Navigation;

class NavigationItem extends Builder
{
    use Common\HasUrl;
    use Common\HasIcon;
    use Common\HasSort;
    use Common\HasBadge;
    use Common\HasLabel;
    use Common\HasHtmlAttributes;
    
    use Common\CanBeHidden;
    use Common\CanBeDisabled;

    use Navigation\Traits\HasGroup;
    use Navigation\Traits\HasActiveIcon;
    
    use Navigation\Traits\CanBeActive;

    final public function __construct(string | \Closure | null $label = null)
    {
        if (filled($label)) {
            $this->label($label);
        }
    }

    public static function make(string | \Closure | null $label = null): static
    {
        $instance = app(static::class, [
            'label' => $label,
        ]);

        $instance->configure();

        return $instance;
    }
}
