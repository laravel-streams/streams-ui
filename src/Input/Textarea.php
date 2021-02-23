<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;

class Textarea extends Input
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
            'template' => 'ui::input/textarea',
            'type' => null,
            'config' => [
                'rows' => 10,
            ]
        ], $attributes));
    }

    public function setValueAttribute($value)
    {
        if (is_array($value)) {
            $value = implode("\n", $value);
        }

        $this->setPrototypeAttributeValue('value', $value);
    }

    public function requestValue()
    {
        $value = parent::requestValue();

        $array = \Streams\Core\Field\Type\Arr::class;

        $array = get_class($this->field->type()) == $array
            || is_subclass_of($this->field->type(), $array);

        if ($array) {
            $value = explode("\n", $value);
        }

        return $value;
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
            'rows' => Arr::get($this->field->config, 'rows', 10)
        ], $attributes));
    }
}
