<div>
    <textarea {!! $this->htmlAttributes([
        'id' => $this->id,
        'name' => $this->name,
        'minlength' => $this->min,
        'maxlength' => $this->max,
        'required' => $this->required,
        'readonly' => $this->readonly,
        'disabled' => $this->disabled,
        'placeholder' => $this->placeholder,
        'rows' => $this->rows,
    ]) !!}>{{ (is_null($this->value) || is_scalar($this->value)) ? $this->value : json_encode($this->value, JSON_PRETTY_PRINT) }}</textarea>
</div>
