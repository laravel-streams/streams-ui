<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Dropdown extends Component
{
    public string $template = 'ui::components.dropdown';

    public array $button = [];
    
    public array $content = [];

    public function onBooted()
    {
        $this->button['attributes']['@click'] = 'open = !open';
    }
}
