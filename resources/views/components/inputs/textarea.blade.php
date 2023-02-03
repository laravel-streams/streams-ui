<div>
    <textarea {!! $component->htmlAttributes([
        'name' => $component->name,
        'minlength' => $component->min,
        'maxlength' => $component->max,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
        'placeholder' => $component->placeholder,
        'rows' => $component->rows,
    ]) !!}>{{ $component->value }}</textarea>
</div>
