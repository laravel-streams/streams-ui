<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Time extends Input
{
    public string $template = 'ui::components.inputs.time';

    public ?string $min = null;
    public ?string $max = null;

    public int $step = 60;

    public ?string $pattern = null;
}
