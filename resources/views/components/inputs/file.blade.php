<div>
    <input {!! $this->htmlAttributes([
        'type' => 'file',
        'accept' => implode(',', []), // 'image/*', 'video/*', 'audio/*', 'application/pdf'
        'capture' => null, // 'user' or 'environment'
        'id' => $this->id,
        'name' => $this->name,
        'value' => $this->value,
        'required' => $this->required,
        'readonly' => $this->readonly,
        'disabled' => $this->disabled,
    ]) !!}>
</div>
