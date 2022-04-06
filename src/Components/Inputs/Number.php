<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class Number extends Input
{
    public string $template = 'ui::components.input.number';

    public string $type = 'number';

    public function htmlAttributes(array $attributes = [])
    {
        return parent::htmlAttributes(array_merge([
            'min' => Arr::get($this->field->ruleParameters($this->field->handle, 'min'), 0),
            'max' => Arr::get($this->field->ruleParameters($this->field->handle, 'max'), 0),
        ], $attributes));
    }
}
