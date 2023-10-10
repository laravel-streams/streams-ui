<div>
    <textarea {!! $component->htmlAttributes([
        'id' => $component->id,
        'name' => $component->name,
        'minlength' => $component->min,
        'maxlength' => $component->max,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
        'placeholder' => $component->placeholder,
        'rows' => $component->rows,
    ]) !!}>{{ (is_null($component->value) || is_scalar($component->value)) ? $component->value : json_encode($component->value, JSON_PRETTY_PRINT) }}</textarea>
</div>
