<?php

namespace Streams\Ui\Builders\Navigation;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\Concerns;
use Streams\Ui\Builders\Navigation;

class NavigationItem extends Builder
{
    use Concerns\HasUrl;
    use Concerns\HasIcon;
    use Concerns\HasSort;
    use Concerns\HasBadge;
    use Concerns\HasLabel;
    use Concerns\HasVisibility;

    use Navigation\Concerns\HasGroup;
    use Navigation\Concerns\HasActiveIcon;
    
    use Navigation\Concerns\CanBeActive;

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
