<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class SelectInput extends Input
{
    public string $template = 'ui::components.inputs.select';

    public array $options = [];

    public ?string $placeholder = null;

    public function options(): array
    {
        return (array) ($this->options ?: $this->field()?->options());
    }
}
