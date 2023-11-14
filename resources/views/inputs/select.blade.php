<div>
    <select {!! $this->htmlAttributes([
        'id' => $this->id,
        'name' => $this->name,
        'required' => $this->required,
        'readonly' => $this->readonly,
        'disabled' => $this->disabled,
    ]) !!}>

        @if (!$this->required)
        <option value="">
            {{ $this->placeholder ? __($this->placeholder) : '---' }}
        </option>
        @endif

        @foreach ($this->options() as $key => $value)
        <option {{ $key == $this->value ? 'selected' : null }} value="{{ $key }}">{{ $value }}</option>
        @endforeach
        
    </select>
</div>
