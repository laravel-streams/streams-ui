<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\URL;
use Streams\Ui\Components\Traits\HasAttributes;

class Navigation extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.navigation';

    public string $activeItemClass = 'active-item';

    public array $items = [];

    public array $attributes = [];
}
