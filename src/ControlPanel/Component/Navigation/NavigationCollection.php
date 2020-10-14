<?php

namespace Streams\Ui\ControlPanel\Component\Navigation;

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
}
