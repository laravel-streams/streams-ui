<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Traits;

class ColorInput extends Input
{
    use Traits\HasPlaceholder;

    protected string $view = 'ui::builders.inputs.color';
}
