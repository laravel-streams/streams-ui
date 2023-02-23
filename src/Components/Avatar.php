<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Avatar extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.avatar';

    public string $src;

    public array $attributes = [];
}
