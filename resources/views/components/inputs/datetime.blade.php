<div>
    <input {!! Html::attributes(
        array_filter([
            'type' => 'datetime-local',
            'id' => $component->id,
            'max' => $component->max,
            'min' => $component->min,
            'step' => $component->step,
            'name' => $component->name,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
            'value' => $component->value?->format('Y-m-d G:i:s'),
        ])
    ) !!}>
</div>
