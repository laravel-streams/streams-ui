<div>
    <input {!! $this->htmlAttributes([
        'id' => $this->id,
        'name' => $this->name,
        'type' => $this->type,
        'step' => $this->step,
        'value' => $this->value,
        'readonly' => $this->readonly,
        'disabled' => $this->disabled,
        'required' => $this->required,
        'placeholder' => $this->placeholder,
        $this->attributeName('min') => $this->min,
        $this->attributeName('max') => $this->max,
    ]) !!}>    
</div>
