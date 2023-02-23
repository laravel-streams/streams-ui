<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Tabs extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.tabs';

    public array $tabs = [];

    public array $attributes = [];
}
