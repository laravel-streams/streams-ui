<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class Integer extends Number
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
            'template' => 'ui::input/integer',
            'config' => [
                'step' => 1,
            ],
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
            'step' => (int) (Arr::get($this->field->config, 'step', 1) ?: 1),
            'min' => Arr::get($this->field->ruleParameters('min'), 0),
            'max' => Arr::get($this->field->ruleParameters('max'), 0),
        ], $attributes));
    }
}
