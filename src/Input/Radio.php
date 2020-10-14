<?php

namespace Streams\Ui\Input;

use Streams\Ui\Support\Component;

/**
 * Class Radio
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Radio extends Component
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
            'template' => 'ui::input/radio',
            'component' => 'input',
            'classes' => [],
        ], $attributes));
    }
}
