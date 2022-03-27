<?php

namespace Streams\Ui\Components\Table\Filter;

use Illuminate\Support\Collection;
use Streams\Ui\Components\Table\Filter\Filter;

class FilterCollection extends Collection
{

    /**
     * Return the active action.
     *
     * @return null|Action
     */
    public function active()
    {
        return $this->filter(function (Filter $item) {
            return $item->active;
        });
    }
}
