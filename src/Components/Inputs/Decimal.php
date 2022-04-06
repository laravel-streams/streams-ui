<?php

namespace Streams\Ui\Components\Inputs;

use Illuminate\Support\Arr;

class Decimal extends Number
{
    public string $template = 'ui::components.inputs.decimal';
    
    public $config = [
        'step' => 0.1,
    ];

    /**
     * Return the HTML attributes array.
     *
     * @param array $attributes
     * @return array
     */
    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'step' => (Arr::get($this->field->config, 'step', 0.1) ?: 0.1),
            'min' => Arr::get($this->field->ruleParameters('min'), 0),
            'max' => Arr::get($this->field->ruleParameters('max'), 0),
        ], $attributes));
    }
}
