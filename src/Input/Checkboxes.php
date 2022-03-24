<?php

namespace Streams\Ui\Input;

class Checkboxes extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    public function initializeComponentPrototype(array $attributes)
    {
        return parent::initializeComponentPrototype(array_merge([
            'template' => 'ui::input/checkboxes',
            'type' => 'checkbox',
        ], $attributes));
    }

    /**
     * Return the HTML attributes array.
     *
     * @param array $attributes
     * @return array
     */
    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'value' => null,
            'name' => $this->name() . '[]',
        ], $attributes));
    }
}
