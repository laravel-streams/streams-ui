<textarea id="{{ $input->field->handle }}" name="{{ $input->field->handle }}" class="{{ implode(' ', $input->classes) }}"
    rows="10">{{ $input->field->value }}</textarea>

<script>
    (function (window, document) {
        var editor = new EasyMDE({
            element: document.getElementById("body")
        });
    })(window, document);
</script>
