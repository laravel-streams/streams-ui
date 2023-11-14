<?php

namespace Streams\Ui\Navigation;

use Streams\Ui\Support\Component;
use Streams\Ui\Navigation\Concerns;
use Streams\Ui\Support\Concerns\HasUrl;
use Streams\Ui\Support\Concerns\HasIcon;
use Streams\Ui\Support\Concerns\HasSort;
use Streams\Ui\Support\Concerns\HasBadge;
use Streams\Ui\Support\Concerns\HasLabel;
use Streams\Ui\Support\Concerns\HasVisibility;

class NavigationItem extends Component
{
    use HasUrl;
    use HasIcon;
    use HasSort;
    use HasBadge;
    use HasLabel;
    use HasVisibility;

    use Concerns\HasGroup;
    use Concerns\HasActiveIcon;
    
    use Concerns\CanBeActive;

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
