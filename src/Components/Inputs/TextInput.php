<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

abstract class TextInput extends Input
{
    public string $type = 'text';

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'name' => $this->name,
            'placeholder' => $this->placeholder,
            'readonly' => $this->readonly,
            'disabled' => $this->disabled,
            'minlength' => $this->min,
            'maxlength' => $this->max,
            'required' => $this->required,
            'pattern' => trim($this->pattern, "//"),
            'value' => $this->value,
            'type' => $this->type,
        ], $attributes));
    }
}
