<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

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

    /**
     * Return the HTML attributes array.
     *
     * @param array $attributes
     * @return array
     */
    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'step' => (int) (Arr::get($this->field->config, 'step', 1) ?: 1),
            'min' => $this->field->getRuleParameter('min'),
            'max' => $this->field->getRuleParameter('max'),
        ], $attributes));
    }
}
