<div>
    <label for="{{ $component->id }}">
        <input {!! Html::attributes(
            array_filter([
                'value' => true,
                'type' => 'checkbox',
                'id'=> $component->id,
                'name'=> $component->name,
                'required' => $component->required,
                'readonly' => $component->readonly,
                'disabled' => $component->disabled,
            ])
        ) !!}> {{ __($component->label) }}
    </label>
</div>
