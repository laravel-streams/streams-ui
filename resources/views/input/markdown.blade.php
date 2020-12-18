{{-- <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script> --}}

<!-- markdown.blade.php -->
<textarea {!! $input->htmlAttributes([
    'rows' => 10,
]) !!}>{{ $input->field->value }}</textarea>

<script>
    window.addEventListener('load', () => {
        window.streams.core.app.get('markdown')({ element: document.getElementById("{{ $input->field->handle }}-input") });
    })
</script>
