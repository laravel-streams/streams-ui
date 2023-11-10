<?php

namespace Streams\Ui\Navigation;

use Streams\Ui\Support\Component;
use Streams\Ui\Navigation\Concerns;

class NavigationItem extends Component
{
    use Concerns\HasUrl;
    use Concerns\HasSort;
    use Concerns\HasIcon;
    use Concerns\HasBadge;
    use Concerns\HasGroup;
    use Concerns\HasLabel;
    use Concerns\HasActive;
    use Concerns\HasActiveIcon;
    use Concerns\HasVisibility;

    final public function __construct(string | \Closure | null $label = null)
    {
        if (filled($label)) {
            $this->label($label);
        }
    }

    public static function make(string | \Closure | null $label = null): static
    {
        $static = new static($label);

        //$static->configure();

        return $static;
    }
}
