<!-- checkbox.blade.php -->
<label for="{{ $input->id() }}">
    <input {!! $input->htmlAttributes([
        'checked' => ($input->value),
    ]) !!}> {{ Arr::get($input->config, 'label') }}
</label>
