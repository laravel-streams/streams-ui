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
            'type' => 'text',
            'field' => null,
            'classes' => [
                'appearance-none',
                'block',
                'w-full',
                'px-3',
                'py-2',
                'border',
                'border-gray-300',
                'rounded-md',
                'placeholder-gray-400',
                'focus:outline-none',
                'focus:shadow-outline-blue',
                'focus:border-blue-300',
                'transition',
                'duration-150',
                'ease-in-out',
                'sm:text-sm',
                'sm:leading-5',
            ],
        ], $attributes));
    }
}
