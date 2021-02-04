<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

class Textarea extends Input
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
            'template' => 'ui::input/textarea',
            'type' => null,
            'config' => [
                'rows' => 10,
            ]
        ], $attributes));
    }

    /**
     * Return the HTML attributes array.
     *
     * @param array $attributes
     * @return array
     */
    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'rows' => Arr::get($this->field->config, 'rows', 10)
        ], $attributes));
    }
}
