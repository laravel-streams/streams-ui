<div>
    <input {!! $component->htmlAttributes([
        'name' => $component->name,
        'type' => $component->type,
        'value' => $component->value,
        'minlength' => $component->min,
        'maxlength' => $component->max,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
    ]) !!}>    
</div>
