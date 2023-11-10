<?php

namespace Streams\Ui\Navigation;

use Streams\Ui\Support\Component;
use Streams\Ui\Navigation\Concerns;

class NavigationGroup extends Component
{
    use Concerns\HasIcon;
    use Concerns\HasItems;
    use Concerns\HasLabel;
    use Concerns\HasCollapsible;

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
