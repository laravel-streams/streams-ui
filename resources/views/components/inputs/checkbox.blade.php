<div>
    <label>
        <input
            value="0"
            type="hidden"
            name="{{ $this->name }}">
            
        <input {!! $this->htmlAttributes([
            'value' => true,
            'type' => 'checkbox',
            'id' => $this->id,
            'name' => $this->name,
            'required' => $this->required,
            'readonly' => $this->readonly,
            'disabled' => $this->disabled,
            'checked' => $this->value == true,
        ]) !!}> {{ __($this->label) }}
    </label>
</div>
