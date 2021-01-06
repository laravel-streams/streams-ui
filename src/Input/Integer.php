<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

/**
 * Class Integer
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Integer extends Number
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
            'template' => 'ui::input/integer',
            'type' => 'number',
            'config' => [
                'step' => 1,
            ],
        ], $attributes));
    }
}
