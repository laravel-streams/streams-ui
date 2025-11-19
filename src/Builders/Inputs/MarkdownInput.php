<?php

namespace Streams\Ui\Builders\Inputs;

class MarkdownInput extends Input
{
    use Concerns\CanBeLengthConstrained;
    use Concerns\HasOptions;
    use Concerns\HasPlaceholder;

    protected string $view = 'ui::components.inputs.markdown';
}
