<?php

namespace Streams\Ui\Input;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;

/**
 * @property string                                 template
 * @property string                                 component
 * @property string[]                               classes
 * @property string                                 type
 * @property \Streams\Ui\Form\Component\Field\Field field
 */
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
            'classes' => [],
            'type' => 'text',
            'placeholder' => null,
            'field' => null,
        ], $attributes));
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'name' => $this->name(),
            'placeholder' => $this->placeholder,
            'readonly' => $this->field->readonly,
            'disabled' => $this->field->disabled,
            'required' => $this->field->hasRule('required'),
            'pattern' => trim($this->field->pattern ?: Arr::get($this->field->ruleParameters('regex'), 0), "//"),
            'value' => $this->value,
            'type' => $this->type,
            'id' => $this->id(),
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

    public function id()
    {
        return $this->id ?: $this->name() . '-input';
    }
}
