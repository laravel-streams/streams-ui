<?php

namespace Streams\Ui\Input;

class Multiselect extends Input
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototypeInstance(array $attributes)
    {
        return parent::initializePrototypeInstance(array_merge([
            'template' => 'ui::input/multiselect',
            'type' => null,
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
            'multiple' => true,
            'name' => $this->name() . '[]',
        ], $attributes));
    }
}
