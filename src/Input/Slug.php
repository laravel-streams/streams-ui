<?php

namespace Streams\Ui\Input;

use Streams\Ui\Support\Component;

/**
 * Class Slug
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class Slug extends Component
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
            'template' => 'ui::input/slug',
            'component' => 'input',
            'classes' => ['input'],
        ], $attributes));
    }
}
