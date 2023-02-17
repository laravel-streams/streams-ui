<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Navigation extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.navigation';

    public string $activeItemClass = 'active-item';

    public array $items = [];

    public array $attributes = [];
}
