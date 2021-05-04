<?php

namespace Streams\Ui\Layout\Navigation;

use Illuminate\Support\Collection;

/**
 * Class NavigationCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class NavigationCollection extends Collection
{

    /**
     * Return the active navigation item.
     *
     * @return null|Action
     */
    public function active()
    {
        return $this->first(function ($item) {
            return $item->active;
        });
    }

    /**
     * Return the children of
     * the provided parent item.
     *
     * @param NavigationItem $parent
     * @return $this
     */
    public function children($parent)
    {
        return $this->filter(function ($item) use ($parent) {

            if (!$item->parent) {
                return false;
            }

            return $item->parent == $parent->id;
        });
    }
}
