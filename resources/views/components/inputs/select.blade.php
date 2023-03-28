<div>
    <select {!! $component->htmlAttributes([
        'id' => $component->name . '-input',
        'name' => $component->name,
        'required' => $component->required,
        'readonly' => $component->readonly,
        'disabled' => $component->disabled,
    ]) !!}>

        @if (!$component->required)
        <option value="">
            {{ $component->placeholder ? __($component->placeholder) : '---' }}
        </option>
        @endif

        @foreach ($component->options() as $key => $value)
        <option {{ $key == $component->value ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
        @endforeach
        
    </select>
</div>
