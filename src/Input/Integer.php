<?php

namespace Streams\Ui\Input;

class Integer extends Number
{

    /**
     * Initialize the prototype.
     *
     * @param array $attributes
     * @return $this
     */
    protected function initializePrototype(array $attributes)
    {
        return parent::initializePrototype(array_merge([
            'template' => 'ui::input/integer',
            'config' => [
                'step' => 1,
            ],
        ], $attributes));
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'min' => $this->field->getRuleParameter('min'),
            'max' => $this->field->getRuleParameter('max'),
        ], $attributes));
    }
}
