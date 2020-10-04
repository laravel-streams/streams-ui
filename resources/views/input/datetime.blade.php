<input type="text" name="{{ $input->field->handle }}" class="{{ implode(' ', $input->classes) }}" />

<script>
    (function (window, document) {
        var input = flatpickr(document.getElementById("{{ $input->field->handle }}"));
    })(window, document);
</script>
