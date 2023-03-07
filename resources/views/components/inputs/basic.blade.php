<div>
    <input {!! $component->htmlAttributes([
        'name' => $component->name,
        'type' => $component->type,
        'step' => $component->step,
        'value' => $component->value(),
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
        'required' => $component->required,
        'placeholder' => $component->placeholder,
        $component->attributeName('min') => $component->min,
        $component->attributeName('max') => $component->max,
    ]) !!}>    
</div>
