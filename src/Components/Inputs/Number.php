<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class Number extends Input
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
            'template' => 'ui::components.input.number',
            'type' => 'number',
        ], $attributes));
    }

    public function htmlAttributes(array $attributes = [])
    {
        return parent::htmlAttributes(array_merge([
            'min' => Arr::get($this->field->ruleParameters($this->field->handle, 'min'), 0),
            'max' => Arr::get($this->field->ruleParameters($this->field->handle, 'max'), 0),
        ], $attributes));
    }
}
