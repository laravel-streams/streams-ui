<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

class EditorInput extends Input
{
    public string $template = 'ui::components.inputs.editor';

    public string $language = 'html'; // https://microsoft.github.io/monaco-editor/typedoc/modules/languages.html
}
