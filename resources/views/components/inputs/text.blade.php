<div>
    <input {!! $component->htmlAttributes([
        'id' => $component->id,
        'name' => $component->name,
        'type' => $component->type,
        'value' => $component->value,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
        'placeholder' => $component->placeholder,
        'required' => $component->required ?? $component->field()?->isRequired(),
        'minlength' => $component->min ?? $component->field()?->ruleParameter('min'),
        'maxlength' => $component->max ?? $component->field()?->ruleParameter('max'),
    ]) !!}>    
</div>
