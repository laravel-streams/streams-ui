<!-- markdown.blade.php -->
<textarea {!! $input->htmlAttributes([
    'rows' => 10,
]) !!}>{{ $input->field->value }}</textarea>

<script>
    window.addEventListener('load', () => {
        new EasyMDE({ element: document.getElementById("{{ $input->field->handle }}") });
    })
</script>
