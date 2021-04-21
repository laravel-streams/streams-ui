<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

class File extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeInstance(array $attributes)
    {
        return parent::initializePrototypeInstance(array_merge([
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
