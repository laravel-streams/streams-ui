<?php

namespace Streams\Ui\Builders\Inputs;

use Streams\Ui\Builders\Inputs\Input;
use Streams\Ui\Builders\Inputs\Concerns;

class MarkdownInput extends Input
{
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;
    use Concerns\CanBeLengthConstrained;

    protected string $view = 'ui::components.inputs.markdown';


}
