<?php

namespace Streams\Ui\Components\ControlPanel\Navigation;

use Illuminate\Support\Collection;
use Streams\Ui\Components\ControlPanel\Navigation\Section;

class NavigationCollection extends Collection
{
    public function active(): Section|null
    {
        return $this->first(function ($item) {
            return $item->active;
        });
    }

    public function children(Section $parent): static
    {
        return $this->filter(function (Section $item) use ($parent) {

            if (!$item->parent) {
                return false;
            }

            return $item->parent === $parent->id;
        });
    }
}
