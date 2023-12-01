@props([
    'inlinePrefix' => false,
    'inlineSuffix' => false,
])

<select
    {{
        $attributes->class([
            'block w-full',
            'rounded-md',
            // 'ps-0' => $inlinePrefix,
            // 'ps-3' => ! $inlinePrefix,
        ])
    }}
>
    {{ $slot }}
</select>
