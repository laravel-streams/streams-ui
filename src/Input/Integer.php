<?php

namespace Streams\Ui\Input;

use Streams\Ui\Support\Component;

/**
 * Class Integer
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Integer extends Component
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
            'component' => 'input',
            'classes' => ['input'],
            'type' => 'text',
            'field' => null,
        ], $attributes));
    }
}
