<div class="field__container">

    <label>{{ $field->label ?: $field->handle }}</label>

    <div class="field__input">
        <pre>{{ $field->type()->value }}</pre>
    </div>

</div>
