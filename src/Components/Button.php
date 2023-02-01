<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;

class Button extends Component
{
    public string $template = 'ui::components.button';

    public string $tag = 'button';

    public ?string $url = null;
    public ?string $text = null;
    public ?string $name = null;
    
    public ?string $type = null; // button, submit, reset

    public function test()
    {
        $this->text = 'Foo Bar';
    }

    //public ?string $icon = null;
    //public ?string $policy = null;
    //public ?string $formaction = null;
    
    //public bool $enabled = true;
    //public bool $primary = false;
    public bool $disabled = false;
    
    //public string $type = 'default';

    //public array $dropdown = [];
}
