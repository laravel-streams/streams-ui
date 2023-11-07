<div>
    <{{ $this->tag }} {!! $this->htmlAttributes([
        'href' => $this->url,
        'name' => $this->name,
        'type' => $this->type,
        'value' => $this->value,
        'disabled' => $this->disabled,
        'class' => [
            'btn',
            'rounded-md',
            'bg-indigo-600',
            'px-2.5',
            'py-1.5',
            'text-sm',
            'font-semibold',
            'text-white',
            'shadow-sm',
            'hover:bg-indigo-500',
            'focus-visible:outline',
            'focus-visible:outline-2',
            'focus-visible:outline-offset-2',
            'focus-visible:outline-indigo-600'
        ]
    ]) !!}>
        {{ __($this->text) }}
    </{{ $this->tag }}>
</div>
