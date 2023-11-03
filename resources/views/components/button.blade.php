<div>
    <button {!! $this->htmlAttributes([
        'href' => $this->url,
        'name' => $this->name,
        'type' => $this->type,
        'value' => $this->value,
        'disabled' => $this->disabled,
    ]) !!}>
        {{ __($this->text) }}
    </button>
</div>
