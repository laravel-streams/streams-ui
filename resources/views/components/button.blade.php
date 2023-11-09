<div>
    <{{ $component->tag }} {!! $component->htmlAttributes([
        'href' => $component->url,
        'name' => $component->name,
        'type' => $component->type,
        'value' => $component->value,
        'disabled' => $component->disabled,
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
        {{ __($component->text) }}
    </{{ $component->tag }}>
</div>
