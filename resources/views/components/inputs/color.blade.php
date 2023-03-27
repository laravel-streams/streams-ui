<div>
    <input {!! $component->htmlAttributes([
        'type' => 'color',
        'id' => $component->id,
        'name' => $component->name,
        'value' => $component->value,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
    ]) !!}>
</div>
