<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Input;
use Streams\Ui\Inputs\Concerns;

class RadioInput extends Input
{
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::components.inputs.radio';
}
