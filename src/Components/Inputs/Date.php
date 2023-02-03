<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Date extends Input
{
    public string $template = 'ui::components.inputs.date';

    public ?string $min = null;
    public ?string $max = null;

    public int $step = 1;

    public ?string $pattern = null;
}
