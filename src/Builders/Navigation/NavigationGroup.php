<?php

namespace Streams\Ui\Builders\Navigation;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Builders\Concerns;
use Streams\Ui\Builders\Navigation;

class NavigationGroup extends Builder
{
    use Concerns\HasIcon;
    use Concerns\HasSort;
    use Concerns\HasLabel;

    use Navigation\Concerns\HasItems;
    use Navigation\Concerns\CanBeCollapsed;

    final public function __construct(string | \Closure | null $label = null)
    {
        $this->label($label);
    }

    public static function make(string | \Closure | null $label = null): static
    {
        $static = new static($label);

        $static->configure();

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
