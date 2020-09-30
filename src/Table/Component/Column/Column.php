<?php

namespace Anomaly\Streams\Ui\Table\Component\Column;

use Anomaly\Streams\Ui\Support\Component;

/**
 * Class Column
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Column extends Component
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'view' => null,
            'value' => null,
            'entry' => null,
            'heading' => null,
            'wrapper' => null,
        ], $attributes));
    }
}
