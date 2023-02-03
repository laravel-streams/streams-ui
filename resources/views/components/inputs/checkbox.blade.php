<div>
    <label>
        <input {!! $component->htmlAttributes([
            'value' => true,
            'type' => 'checkbox',
            'name' => $component->name,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
        ]) !!}> {{ __($component->label) }}
    </label>
</div>
