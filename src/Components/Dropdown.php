<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Dropdown extends Component
{
    public string $template = 'ui::components.dropdown';

    public array $toggle = [];
    
    public array $components = [];
}
