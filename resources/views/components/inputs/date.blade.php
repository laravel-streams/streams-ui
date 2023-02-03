<div>
    <input {!! $component->htmlAttributes([
        'type' => 'date',
        'max' => $component->max,
        'min' => $component->min,
        'step' => $component->step,
        'name' => $component->name,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
        'value' => $component->value?->format('Y-m-d'),
    ]) !!}>
</div>
