<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class SelectInput extends Input
{
    public string $template = 'ui::components.inputs.select';

    public array $options = [];

    public function options()
    {
        return $this->options ?: $this->field()?->options();
    }
}
