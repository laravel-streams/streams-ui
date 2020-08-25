<div class="field__container">

    <label>{{ $field->label ?: $field->handle }}</label>

    <div class="field__input">
        {!! $field->input() !!}
    </div>

</div>
