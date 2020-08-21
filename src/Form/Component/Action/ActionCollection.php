<?php

namespace Anomaly\Streams\Ui\Form\Component\Action;

use Anomaly\Streams\Ui\Button\ButtonCollection;

/**
 * Class ActionCollection
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ActionCollection extends ButtonCollection
{

    /**
     * Return the active action.
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
     * Find a action by it's handle.
     *
     * @param $handle
     * @return null|ActionInterface
     */
    public function findByHandle($handle)
    {
        return $this->first(function ($item) use ($handle) {
            return $item->handle == $handle;
        });
    }
}
