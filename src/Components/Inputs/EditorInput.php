<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class EditorInput extends Input
{
    public string $template = 'ui::components.inputs.editor';

    public string $language = 'html'; // https://microsoft.github.io/monaco-editor/typedoc/modules/languages.html

    public function boot()
    {
        if (is_array($this->value) || is_object($this->value)) {
            $this->value = json_encode($this->value, JSON_PRETTY_PRINT);
        }
    }
}
