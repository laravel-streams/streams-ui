<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Indicator extends Component
{
    public string $template = 'ui::components.indicator';

    public ?string $text = null;
}
