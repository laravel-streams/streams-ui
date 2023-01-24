<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Editor extends Input
{
    public string $template = 'ui::components.inputs.editor';

    public function setValueAttribute($value)
    {
        if (is_object($value) || is_array($value)) {
            $value = json_encode($value);
        }

        $this->value = $value;
    }
}
