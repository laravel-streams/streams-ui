<div>
    <input {!! $this->htmlAttributes([
        'type' => 'range',
        'id' => $this->id,
        'max' => $this->max,
        'min' => $this->min,
        'name' => $this->name,
        'step' => $this->step,
        'value' => $this->value,
        'required' => $this->required,
        'readonly' => $this->readonly,
        'disabled' => $this->disabled,
    ]) !!}>
</div>
