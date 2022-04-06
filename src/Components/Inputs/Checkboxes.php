<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Checkboxes extends Input
{
    public string $template = 'ui::components.input.checkboxes';

    public string $type = 'checkbox';

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'value' => null,
            'name' => $this->name() . '[]',
        ], $attributes));
    }
}
