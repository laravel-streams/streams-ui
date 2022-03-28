<textarea {!! $input->htmlAttributes([
    'rows' => 10,
    //'x-data' => "sterams.core.app.get('input.markdown')({$input->toJson()})",
    'x-data' => $input->toJson(),
    //'x-init' => 'init()',
    'x-model' => 'value'
]) !!}></textarea>
