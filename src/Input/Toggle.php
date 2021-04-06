<?php

namespace Streams\Ui\Input;

use Streams\Ui\Input\Input;

class Toggle extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeTrait(array $attributes)
    {
        return parent::initializePrototypeTrait(array_merge([
            'template' => 'ui::input/toggle',
            'type' => 'checkbox',
        ], $attributes));
    }
}
