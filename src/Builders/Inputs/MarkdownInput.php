<?php

namespace Streams\Ui\Inputs;

use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\Traits;

class MarkdownInput extends Input
{
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;
    use Concerns\CanBeLengthConstrained;

    protected string $view = 'ui::components.inputs.markdown';


}
