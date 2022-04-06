<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class Range extends Input
{
    public string $template = 'ui::components.input.range';

    public string $type = 'range';

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'min' => Arr::get($this->field->config, 'rows', 0),
            'max' => Arr::get($this->field->config, 'rows', 100),
        ], $attributes));
    }
}
