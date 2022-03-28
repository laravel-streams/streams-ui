<?php

namespace Streams\Ui\Components\Inputs;

use Illuminate\Support\Arr;

class Integer extends Number
{
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::components.inputs.integer',
            'config' => [
                'step' => 1,
            ],
        ], $attributes));
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'step' => (int) (Arr::get($this->field->config, 'step', 1) ?: 1),
            'min' => Arr::get($this->field->ruleParameters('min'), 0),
            'max' => Arr::get($this->field->ruleParameters('max'), 0),
        ], $attributes));
    }
}
