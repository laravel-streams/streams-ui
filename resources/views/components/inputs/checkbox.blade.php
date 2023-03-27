<div>
    <label>
        <input
            value="0"
            type="hidden"
            name="{{ $component->name }}">
            
        <input {!! $component->htmlAttributes([
            'value' => true,
            'type' => 'checkbox',
            'id' => $component->name . '-input',
            'name' => $component->name,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
            'checked' => $component->value == true,
        ]) !!}> {{ __($component->label) }}
    </label>
</div>
