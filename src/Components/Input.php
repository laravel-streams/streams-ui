<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Arr;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;

class Input extends Component
{
    public string $template = 'ui::components.input';
    public string $component = 'input';
    
    public $classes = [
        'a-input',
    ];

    //public object $field;
    
    public string $type = 'text';
    public ?string $placeholder = null;

    public function config(string $key, $default = null)
    {
        return Arr::get((array) $this->getPrototypeAttribute('config'), $key, $default);
    }

    public function post()
    {
        $this->value = Request::file($this->name()) ?: $this->request($this->name());

        return $this;
    }

    public function label()
    {
        return $this->label ?: $this->field->name();
    }

    public function name()
    {
        return $this->name ?: ($this->prefix . $this->field->handle);
    }

    public function setValueAttribute($value)
    {
        if (is_object($value) || is_array($value)) {
            $value = json_encode($value);
        }

        $this->value = $value;
    }

    public function attributes(array $attributes = [])
    {
        return parent::attributes(array_merge([
            'name' => $this->name(),
            'placeholder' => $this->placeholder,
            'readonly' => $this->field?->readonly,
            'disabled' => $this->field?->disabled,
            'required' => $this->field?->hasRule('required'),
            'pattern' => trim($this->field?->pattern ?: Arr::get($this->field?->ruleParameters('regex'), 0), "//"),
            'value' => $this->value,
            'type' => $this->type,
        ], $attributes));
    }
}
