<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Inputs\Input;
use Streams\Ui\Inputs\Traits;

class MarkdownInput extends Input
{
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;
    use Concerns\CanBeLengthConstrained;

    protected string $view = 'ui::components.inputs.markdown';


}
