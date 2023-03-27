<div>
    <input {!! $component->htmlAttributes([
        'type' => 'file',
        'accept' => implode(',', []), // 'image/*', 'video/*', 'audio/*', 'application/pdf'
        'capture' => null, // 'user' or 'environment'
        'id' => $component->id,
        'name' => $component->name,
        'value' => $component->value,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
    ]) !!}>
</div>
