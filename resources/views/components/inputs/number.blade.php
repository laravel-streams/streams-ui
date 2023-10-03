<div>
    <input {!! $component->htmlAttributes([
        'id' => $component->id,
        'name' => $component->name,
        'value' => $component->value,
        'type' => $component->type,
        'step' => $component->step,
        'min' => $component->min,
        'max' => $component->max,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
        'placeholder' => $component->placeholder,
    ]) !!}>    
</div>
