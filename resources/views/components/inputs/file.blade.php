<div>
    <input {!! Html::attributes(
        array_filter([
            'type'=> 'file',
            'id'=> $component->id,
            'name'=> $component->name,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
        ])
    ) !!}>
</div>
