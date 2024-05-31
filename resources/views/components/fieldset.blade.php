@props([
    'label' => null,
    'labelHidden' => false,
])

<fieldset
    {{
        $attributes->class([
            'flex flex-col gap-4 rounded-xl border border-gray-300 p-6',
        ])
    }}
>
    @if (filled($label))
        <legend
            @class([
                '-ms-2 px-2 font-medium leading-6 text-gray-950',
                'sr-only' => $labelHidden,
            ])
        >
            {{ $label }}
        </legend>
    @endif

    {{ $slot }}
</fieldset>
