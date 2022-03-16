<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

class Range extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializeComponentPrototype(array $attributes)
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::input/range',
            'type' => 'range',
            'classes' => [],
        ], $attributes));
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'min' => Arr::get($this->field->config, 'rows', 0),
            'max' => Arr::get($this->field->config, 'rows', 100),
        ], $attributes));
    }
}
