<?php /** @var \Streams\Ui\Input\Markdown $input */ ?>

<!-- markdown.blade.php -->
<textarea {!! $input->htmlAttributes([
    'rows' => 10,
]) !!}>{{ $input->field->value }}</textarea>

{{--receive this? gimme a SS--}}
<script>
window.addEventListener('load', () => {
    window.streams.core.app.get('field.markdown')
        .init("#{{ $input->field->handle }}-input")
        .then(function (input) {
            console.log("#{{ $input->field->handle }}-input", input);
            return input;
        });
});
</script>
