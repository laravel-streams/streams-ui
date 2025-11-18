<?php

namespace Streams\Ui\Builders\Navigation;

use Streams\Ui\Builders\Builder;
use Streams\Ui\Traits as Common;
use Streams\Ui\Builders\Navigation;

class NavigationGroup extends Builder
{
    use Common\CanBeHidden;
    use Common\HasIcon;
    use Common\HasLabel;
    use Common\HasSort;
    use Navigation\Traits\CanBeCollapsed;
    use Navigation\Traits\HasItems;

    final public function __construct(string|\Closure|null $label = null)
    {
        $this->label($label);
    }

    public static function make(string|\Closure|null $label = null): static
    {
        $instance = app(static::class, [
            'label' => $label,
        ]);

        $instance->configure();

        return $instance;
    }

    public function isActive(): bool
    {
        foreach ($this->getItems() as $item) {

            if (! $item->isActive()) {
                continue;
            }

            return true;
        }

        return false;
    }
}
