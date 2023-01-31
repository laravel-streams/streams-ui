<div>
    <input {!! Html::attributes(
        array_filter([
            'type' => 'number',
            'id' => $component->id,
            'min' => $component->min,
            'max' => $component->max,
            'name' => $component->name,
            'step' => $component->step,
            'value' => $component->value,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
            'placeholder' => $component->placeholder,
            'pattern' => trim($component->pattern, "//"),
        ])
    ) !!}>    
</div>
