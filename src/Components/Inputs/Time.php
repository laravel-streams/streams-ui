<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class Time extends Input
{
    public string $template = 'ui::components.input.time';

    public string $type = 'time';

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'step' => (int) (Arr::get($this->field->config, 'step', 1) ?: 1),
            'min' => Arr::get($this->field->ruleParameters('min'), 0),
            'max' => Arr::get($this->field->ruleParameters('max'), 0),
        ], $attributes));
    }
}
