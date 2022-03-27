<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Image extends File
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::input/image',
            'accept' => [
                'image/png',
                'image/jpg',
                'image/jpeg',
            ]
        ], $attributes));
    }
}
