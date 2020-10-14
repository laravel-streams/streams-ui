<?php

namespace Streams\Ui\Table\Component\View;

use Illuminate\Support\Collection;
use Streams\Ui\Table\Component\View\View;

/**
 * Class ViewCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ViewCollection extends Collection
{

    /**
     * Return the active view or null.
     *
     * @return null|View
     */
    public function active()
    {
        return $this->first(function ($item) {
            return $item->active;
        });
    }

    /**
     * Find a view by it's handle.
     *
     * @param $handle
     * @return null|View
     */
    public function findByHandle($handle)
    {
        return $this->first(function ($item) use ($handle) {
            return $item->handle === $handle;
        });
    }
}
