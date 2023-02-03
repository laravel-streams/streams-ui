<div>
    <input {!! $component->htmlAttributes([
        'type' => 'color',
        'name' => $component->name,
        'value' => $component->value,
        'pattern' => $component->pattern,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
    ]) !!}>
</div>
