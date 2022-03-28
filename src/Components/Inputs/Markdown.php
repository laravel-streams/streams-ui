<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class Markdown extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    public function initializeComponentPrototype(array $attributes = [])
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::components.inputs.markdown',
            'component' => 'input',
        ], $attributes));
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'rows' => Arr::get($this->field->config, 'rows', 10)
        ], $attributes));
    }
}
