<?php

namespace Streams\Ui\Input;

use Streams\Ui\Support\Component;

/**
 * Class Color
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Color extends Component
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
            'template' => 'ui::input/color',
            'component' => 'input',
            'classes' => [],
        ], $attributes));
    }
}
