<div x-data="{value: '{{ $this->value }}'}">
    <input {!! $this->htmlAttributes([
        'name' => $this->name,
        'type' => $this->type,
        'value' => $this->value,
        'readonly' => $this->readonly,
        'disabled' => $this->disabled,
        'placeholder' => $this->placeholder,
        'required' => $this->required ?? $this->field()?->isRequired(),
        'minlength' => $this->min ?? $this->field()?->ruleParameter('min'),
        'maxlength' => $this->max ?? $this->field()?->ruleParameter('max'),
    ]) !!}
    x-model="value"
    x-on:keyup="value = String(value)
        .toLowerCase()
        .replace(/ /g,'{{ $this->separator }}')
        .replace(/[^\w-_]+/g,'{{ $this->separator }}')
        // Collapse dashes
        .replace(/-+/g, '{{ $this->separator }}');">
</div>

{{-- @todo 
@if ($this->field()?->config('slugify'))
<script>
    document.getElementById('{{ $this->field()?->config('slugify') }}-input')
        .addEventListener('keydown', function() {
            document.getElementById('{{ $this->id }}-input'). = String(this.value)
                .toLowerCase()
                .replace(/ /g,'{{ $this->separator }}')
                .replace(/[^\w-_]+/g,'{{ $this->separator }}')
                // Collapse dashes
                .replace(/-+/g, '{{ $this->separator }}');
                
    });
</script>
@endif
--}}
