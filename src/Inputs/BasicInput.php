<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class BasicInput extends Input
{
    public int|string|null $min = null;
    public int|string|null $max = null;
    
    public string $type = 'text';
    
    public ?string $placeholder = null;

    public ?string $pattern = null;
    
    public int|float|null $step = null;

    protected $dates = [
        'date' => 'Y-m-d',
        'time' => 'H:i:s',
        'datetime-local' => 'Y-m-d\TH:i:s',
    ];

    public function render()
    {
        return view('ui::components.inputs.basic');        
    }

    public function attributeName($base)
    {
        $strings = ['text', 'search', 'url', 'tel', 'email', 'password'];

        return in_array($this->type, $strings) ? $base . 'length' : $base;
    }
}
