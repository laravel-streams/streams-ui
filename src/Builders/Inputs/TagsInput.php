<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;
use Illuminate\Support\Collection;

class TagsInput extends Input
{
    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $placeholder = null;

    public function render()
    {
        return view('ui::components.inputs.tags');
    }

    // public function post()
    // {
    //     $value = parent::post();

    //     return (new Collection(json_decode($value, true)))->pluck('value')->all();
    // }
}
