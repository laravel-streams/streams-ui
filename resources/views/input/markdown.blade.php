<!-- markdown.blade.php -->
<textarea id="{{ $input->field->handle }}" name="{{ $input->name }}" class="{{ implode(' ', $input->classes) }}"
    rows="10">{{ $input->field->value }}</textarea>

<script>
    window.addEventListener('load', () => {
        new EasyMDE({ element: document.getElementById("{{ $input->field->handle }}") });
    })
</script>
