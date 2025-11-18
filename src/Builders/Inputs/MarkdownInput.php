<?php

namespace Streams\Ui\Builders\Inputs;

class MarkdownInput extends Input
{
    use Traits\CanBeLengthConstrained;
    use Traits\HasOptions;
    use Traits\HasPlaceholder;

    protected string $view = 'ui::components.inputs.markdown';
}
