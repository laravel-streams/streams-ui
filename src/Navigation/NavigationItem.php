<?php

namespace Streams\Ui\Navigation;

use Streams\Ui\Navigation;
use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Common;

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
        $static = new static($label);

        $static->configure();

        return $static;
    }
}
