<div>
    <input {!! $component->attributes(
        array_filter([
            'id' => $component->id,
            'name' => $component->name,
            'type' => $component->type,
            'value' => $component->value,
            'minlength' => $component->min,
            'maxlength' => $component->max,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
            'placeholder' => $component->placeholder,
            'pattern' => trim($component->pattern, "//"),
        ])
    ) !!}>    
</div>
