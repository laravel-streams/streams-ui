<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\Traits;

class RadioInput extends Input
{
    use Traits\HasOptions;
    use Traits\HasPlaceholder;

    protected string $view = 'ui::components.inputs.radio';
}
