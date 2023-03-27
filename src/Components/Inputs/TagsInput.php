<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;
use Illuminate\Support\Collection;

class TagsInput extends Input
{
    public string $template = 'ui::components.inputs.tags';

    public ?int $min = null;
    public ?int $max = null;
    
    public ?string $placeholder = null;

    public function post()
    {
        $value = parent::post();

        return (new Collection(json_decode($value, true)))->pluck('value')->all();
    }
}
