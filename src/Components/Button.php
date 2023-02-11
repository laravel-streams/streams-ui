<?php

namespace Streams\Ui\Components;

class Button extends Anchor
{
    public string $template = 'ui::components.button';

    public string $tag = 'button';

    public ?string $name = null;
    
    public ?string $type = null; // button, submit, reset
    
    public bool $disabled = false;
    
    public $value = null;
}
