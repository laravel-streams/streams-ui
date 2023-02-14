<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class EditorInput extends Input
{
    public string $template = 'ui::components.inputs.editor';

    public string $language = 'html'; // html, css, javascript, json, php, xml, yaml, blade, twig, markdown, plaintext (manaco-editor)

    public function booted()
    {
        // Ensure the value is JSON a string.
        if (is_object($this->value) || is_array($this->value)) {
            
            $this->value = json_encode($this->value);
            
            $this->language = 'json';
        }
    }
}
