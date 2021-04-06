<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

class Markdown extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeTrait(array $attributes)
    {
        return parent::initializePrototypeTrait(array_merge([
            'template' => 'ui::input/markdown',
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
