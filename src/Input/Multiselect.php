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
    protected function initializeElementPrototype(array $attributes)
    {
        return parent::initializeElementPrototype(array_merge([
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
