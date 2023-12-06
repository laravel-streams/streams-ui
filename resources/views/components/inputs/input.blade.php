@props([
    'inlinePrefix' => false,
    'inlineSuffix' => false,
])

<input
    {{
        $attributes->class([
            'block',
            'rounded-md',
            'px-3 py-2',
            'ps-0' => $inlinePrefix,
            'ps-3' => ! $inlinePrefix,
            'pe-0' => $inlineSuffix,
            'pe-3' => ! $inlineSuffix,
        ])
    }}
/>
