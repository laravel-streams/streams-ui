@props([
    'inlinePrefix' => false,
    'inlineSuffix' => false,
])

<input
    {{
        $attributes->class([
            //'block w-full',
            'rounded-md',
            'ps-0' => $inlinePrefix,
            'ps-3' => ! $inlinePrefix,
            'pe-0' => $inlineSuffix,
            'pe-3' => ! $inlineSuffix,
        ])
    }}
/>
