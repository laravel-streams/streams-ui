<?php

namespace Streams\Ui\Components\Inputs;

use Streams\Ui\Components\Input;

use Illuminate\Support\Arr;

class Textarea extends Input
{

    public string $template = 'ui::components.inputs.textarea';

    public $config = [
        'rows' => 5,
    ];

    public function load($value)
    {
        if (is_array($value)) {
            $value = implode("\n", $value);
        }

        return parent::load($value);
    }

    public function value()
    {
        $value = parent::value();

        $type = $this->field->type();

        if (
            is_a($type, \Streams\Core\Field\Type\Arr::class)
            || is_subclass_of($type, \Streams\Core\Field\Type\Arr::class)
        ) {
            return explode("\n", $value);
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
            'rows' => Arr::get($this->config, 'rows', 10)
        ], $attributes));
    }
}
