<div>
    <select {!! Html::attributes(
        array_filter([
            'id'=> $component->id,
            'name'=> $component->name,
            'required' => $component->required,
            'readonly' => $component->readonly,
            'disabled' => $component->disabled,
        ])
    ) !!}>

    @if (!$component->required)
        <option value="">---</option>
    @endif

    @foreach ($component->options() as $key => $value)
        <option {{ $key == $component->value ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
    @endforeach
    </select>
</div>
