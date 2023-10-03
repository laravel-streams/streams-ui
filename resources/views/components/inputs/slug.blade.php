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
        .replace(/ /g,'{{ $component->separator }}')
        .replace(/[^\w-_]+/g,'{{ $component->separator }}')
        // Collapse dashes
        .replace(/-+/g, '{{ $component->separator }}');">
</div>

{{-- @todo 
@if ($component->field()?->config('slugify'))
<script>
    document.getElementById('{{ $component->field()?->config('slugify') }}-input')
        .addEventListener('keydown', function() {
            document.getElementById('{{ $component->id }}-input'). = String(this.value)
                .toLowerCase()
                .replace(/ /g,'{{ $component->separator }}')
                .replace(/[^\w-_]+/g,'{{ $component->separator }}')
                // Collapse dashes
                .replace(/-+/g, '{{ $component->separator }}');
                
    });
</script>
@endif
--}}
