<!-- select.blade.php -->
<select {!! $input->htmlAttributes([
    'type' => null,
]) !!}>

@if (!$input->field->isRequired())
    <option value="">---</option>
@endif

@foreach ($input->field->config['options'] as $key => $value)
    <option {{ $key == $input->value ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
@endforeach
</select>
