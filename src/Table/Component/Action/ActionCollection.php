<?php

namespace Streams\Ui\Table\Component\Action;

use Streams\Ui\Button\ButtonCollection;
use Streams\Ui\Table\Component\Action\Action;

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
}
