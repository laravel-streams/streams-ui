<?php

namespace Streams\Ui\Components\Table\Action;

use Illuminate\Support\Collection;
use Streams\Ui\Components\Table\Action\Action;

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
