<?php

namespace Streams\Ui\Input;

use Streams\Ui\Support\Component;

class Input extends Component
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
            'template' => 'ui::input/input',
            'component' => 'input',
            'classes' => [
                'appearance-none',
                'w-full',
                'block',
                'px-3',
                'py-2',
                'rounded-md',
                
                'border-2',
                'border-black',

                'placeholder-gray-400',
                
                'focus:outline-none',
                'focus:shadow-outline-blue',
                'focus:border-blue-500',

                'transition',
                'duration-150',
                'ease-in-out',

                'sm:text-sm',
                'sm:leading-5',
            ],
            'type' => 'text',
            'field' => null,
        ], $attributes));
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'id' => $this->id ?: $this->name . '-input',
            'name' => $this->name,
            'value' => $this->value ?: $this->field->value,
        ], $attributes));
    }
}
