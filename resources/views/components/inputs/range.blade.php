<div>
    <input {!! $component->htmlAttributes([
        'type' => 'range',
        'id' => $component->id,
        'max' => $component->max,
        'min' => $component->min,
        'name' => $component->name,
        'step' => $component->step,
        'value' => $component->value,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
    ]) !!}>
</div>
