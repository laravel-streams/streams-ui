<?php

namespace Streams\Ui\Table\Action;

use Illuminate\Support\Collection;
use Streams\Ui\Table\Action\Action;

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
}
