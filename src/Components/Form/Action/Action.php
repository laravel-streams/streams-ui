<?php

namespace Streams\Ui\Components\Form\Action;

use Streams\Ui\Components\Button;

class Action extends Button
{
    public string $component = 'action';
    
    public string $tag = 'button';
    
    public ?string $url = null;
    public ?string $text = null;
    public ?string $entry = null;
    public ?string $policy = null;
    
    public bool $enabled = true;
    public bool $disabled = false;
    
    public string $type = 'default';

    // Extended
    public $redirect = null;

    public bool $active = false;

    public function attributes(array $attributes = [])
    {
        return array_merge(parent::attributes(), [
            'value' => $this->handle,
            'type'  => $this->type,
            'name'  => 'action',
        ], $attributes);
    }
}
