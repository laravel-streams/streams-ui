<div x-data="{value: '{{ $component->value }}'}">
    <input {!! $component->htmlAttributes([
        'name' => $component->name,
        'type' => $component->type,
        'value' => $component->value,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
        'placeholder' => $component->placeholder,
        'required' => $component->required ?? $component->field()?->isRequired(),
        'minlength' => $component->min ?? $component->field()?->ruleParameter('min'),
        'maxlength' => $component->max ?? $component->field()?->ruleParameter('max'),
    ]) !!}
    x-model="value"
    x-on:keyup="value = String(value)
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-_]+/g,'')
        // Collapse dashes
        .replace(/-+/g, '-');">    
</div>
