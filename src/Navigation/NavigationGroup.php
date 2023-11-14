<?php

namespace Streams\Ui\Navigation;

use Streams\Ui\Support\Component;
use Streams\Ui\Navigation\Concerns;
use Streams\Ui\Support\Concerns\HasIcon;
use Streams\Ui\Support\Concerns\HasLabel;
use Streams\Ui\Support\Concerns\HasSort;

class NavigationGroup extends Component
{
    
    use HasIcon;
    use HasSort;
    use HasLabel;

    use Concerns\HasItems;
    use Concerns\CanBeCollapsed;

    final public function __construct(string | \Closure | null $label = null)
    {
        $this->label($label);
    }

    public static function make(string | \Closure | null $label = null): static
    {
        $static = new static($label);

        //$static->configure();

        return $static;
    }

    public function isActive(): bool
    {
        foreach ($this->getItems() as $item) {

            if (!$item->isActive()) {
                continue;
            }

            return true;
        }

        return false;
    }
}
