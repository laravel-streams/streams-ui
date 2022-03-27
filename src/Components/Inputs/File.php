<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class File extends Input
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
            'template' => 'ui::input/file',
            'type' => 'file',
            'accept' => [
                // "image/png",
                // "image/jpeg"
            ],
        ], $attributes));
    }

    public function attributes(array $attributes = [])
    {
        $accept = $this->accept ?: Arr::get($this->field->config, 'accept', []);

        return parent::attributes(array_merge([
            'accept' => implode(', ', $accept),
        ], $attributes));
    }
}
