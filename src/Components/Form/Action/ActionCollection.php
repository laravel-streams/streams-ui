<?php

namespace Streams\Ui\Components\Form\Action;

use Illuminate\Support\Collection;

class ActionCollection extends Collection
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
