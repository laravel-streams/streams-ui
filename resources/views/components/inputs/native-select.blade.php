@props([
    'inlinePrefix' => false,
    'inlineSuffix' => false,
    'borderRadius' => 'md',
])

<select
    {{
        $attributes->class([
            'block w-full',
            "rounded-{$borderRadius}",
            // 'ps-0' => $inlinePrefix,
            // 'ps-3' => ! $inlinePrefix,
        ])
    }}
>
    {{ $slot }}
</select>
