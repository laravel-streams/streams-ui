<?php

namespace Streams\Ui\Navigation;

use Streams\Ui\Navigation;
use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Common;

class NavigationGroup extends Builder
{
    use Common\HasIcon;
    use Common\HasSort;
    use Common\HasLabel;

    use Navigation\Traits\HasItems;
    use Navigation\Traits\CanBeCollapsed;

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
