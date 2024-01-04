<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Traits;

class ColorInput extends Input
{
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::builders.inputs.color';
}
