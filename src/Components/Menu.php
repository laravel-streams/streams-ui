<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Menu extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.menu';

    public array $items = [];

    public array $attributes = [];
}
