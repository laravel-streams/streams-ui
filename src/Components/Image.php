<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Image extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.image';

    public string $src;

    public array $attributes = [];
}
