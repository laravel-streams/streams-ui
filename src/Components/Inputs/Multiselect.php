<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class Multiselect extends Input
{
    public string $template = 'ui::components.input.multiselect';

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'value' => null,
            'multiple' => true,
            'name' => $this->name() . '[]',
        ], $attributes));
    }

    public function load($value)
    {
        if (
            isset($value)
            && is_string($value)
            && $json = json_decode($value, true)
            ) {
                $value = $json;
        }
        
        $this->value = $value;

        return $this;
    }
}
