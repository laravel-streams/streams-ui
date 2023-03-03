<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class EditorInput extends Input
{
    public string $template = 'ui::components.inputs.editor';

    public string $language = 'html'; // https://microsoft.github.io/monaco-editor/api/enums/monaco.languages.html

    public function boot()
    {
        if (is_object($this->value) || is_array($this->value)) {
            
            $this->value = json_encode($this->value);
            
            $this->language = 'json';
        }
    }
}
