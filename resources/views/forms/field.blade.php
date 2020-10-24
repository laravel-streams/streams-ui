<div {!! $field->htmlAttributes() !!}>

    <label>{{ $field->label ?: $field->handle }}</label>

    <div class="field__input">
        {!! $field->input() !!}
    </div>

</div>
