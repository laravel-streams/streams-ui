<div {!! $field->htmlAttributes() !!}>

    <label>{{ $field->label ?: $field->handle }}</label>

    <div class="">
        {!! $field->input() !!}
    </div>

</div>
