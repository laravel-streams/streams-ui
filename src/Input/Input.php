<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;
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

                'border-2',
                'border-black',
                'dark:border-white',
                'dark:focus:border-blue',

                'bg-white',
                'dark:bg-gray',

                'placeholder-gray-400',

                'focus:outline-none',
                'focus:shadow-outline-blue',
                'focus:border-blue',

                'duration-150',
                'ease-in-out',
                'transition',

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
            'id' => $this->getPrototypeAttribute('id') ?: $this->field->handle . '-input',
            'name' => $this->getPrototypeAttribute('name') ?: $this->field->handle,
            'placeholder' => $this->placeholder,
            'required' => $this->field->hasRule('required'),
            'readonly' => $this->field->readonly ? 'readonly' : null,
            'disabled' => $this->field->disabled ? 'disabled' : null,
            'pattern' => trim($this->field->pattern ?: Arr::get($this->field->stream->getRuleParameters($this->field->handle, 'regex'), 0), "//"),
            'type' => $this->type,
            'value' => $this->value,
        ], $attributes));
    }

    public function label()
    {
        return $this->label ?: $this->field->name();
    }

    public function name()
    {
        return $this->name ?: ($this->prefix . $this->field->handle);
    }
}
