<?php

namespace Streams\Ui\Components\Inputs;

use Illuminate\Support\Arr;

class Integer extends Number
{
    public string $template = 'ui::components.inputs.integer';

    public $config = [
        'step' => 1,
    ];

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'step' => $this->field?->config('step', 1),
            'min' => $this->field?->ruleParameter('min'),
            'max' => $this->field?->ruleParameter('max'),
        ], $attributes));
    }
}
