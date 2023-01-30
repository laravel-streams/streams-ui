<div>
    <textarea {!! Html::attributes(
        array_filter([
            'id'=> $component->id,
            'name'=> $component->name,
            'minlength' => $component->min,
            'maxlength' => $component->max,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
            'placeholder' => $component->placeholder,
            'rows'=> $component->rows,
        ])
    ) !!}>{{ $component->value }}</textarea>
</div>
