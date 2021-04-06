<?php

namespace Streams\Ui\Input;

class Image extends File
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
            'template' => 'ui::input/image',
            'accept' => [
                'image/png',
                'image/jpg',
                'image/jpeg',
            ]
        ], $attributes));
    }
}
