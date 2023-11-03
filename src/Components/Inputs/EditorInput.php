<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class EditorInput extends Input
{
    // https://microsoft.github.io/monaco-editor/typedoc/modules/languages.html
    public string $language = 'html';

    public function render()
    {
        return view('ui::components.inputs.editor');
    }

    public function boot()
    {
        if (is_array($this->value) || is_object($this->value)) {
            $this->value = json_encode($this->value, JSON_PRETTY_PRINT);
        }
    }
}
