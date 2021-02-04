<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

class Decimal extends Number
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
            'template' => 'ui::input/decimal',
            'config' => [
                'step' => 0.1,
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
            'step' => (Arr::get($this->field->config, 'step', 0.1) ?: 0.1),
            'min' => $this->field->getRuleParameter('min'),
            'max' => $this->field->getRuleParameter('max'),
        ], $attributes));
    }
}
