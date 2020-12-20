<!-- markdown.blade.php -->
<textarea {!! $input->htmlAttributes([
    'rows' => 10,
]) !!}>{{ $input->field->value }}</textarea>
{{--
<script>
    window.addEventListener('load', () => {
        window.streams.core.app.get('markdown')({
            element: document.getElementById("{{ $input->field->handle }}-input")
        });
    })
</script>
--}}
