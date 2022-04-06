<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class Datetime extends Input
{
    public string $template = 'ui::components.input.datetime';
    public string $type = 'datetime-local';

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
            'min' => Arr::get($this->field->ruleParameters('after'), 0),
            'max' => Arr::get($this->field->ruleParameters('before'), 0),
        ], $attributes));
    }
}
