<?php

namespace Streams\Ui\Components;

use Streams\Ui\Support\Component;
use Streams\Ui\Components\Traits\HasAttributes;

class Button extends Component
{
    use HasAttributes;

    public string $template = 'ui::components.button';

    public string $tag = 'button';

    public ?string $href = null;
    public ?string $text = null;
    public ?string $name = null;
    
    public ?string $type = null; // button, submit, reset
    
    public bool $disabled = false;
    
    public $value = null;

    public $attributes = [];
}
