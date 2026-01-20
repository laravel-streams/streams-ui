@props([
    'inlinePrefix' => false,
    'inlineSuffix' => false,
    'accept' => null,
    'capture' => null,
    'multiple' => false,
])

<input
    type="file"
    {{
        $attributes->merge([
            'accept' => $accept,
            'capture' => $capture,
            'multiple' => $multiple,
        ])->class([
            'block',
            'w-full',
            'rounded-md',
            'px-3 py-2',
            'ps-0' => $inlinePrefix,
            'ps-3' => ! $inlinePrefix,
            'pe-0' => $inlineSuffix,
            'pe-3' => ! $inlineSuffix,
            'border-gray-300',
            'shadow-sm',
            'focus:border-indigo-500',
            'focus:ring-indigo-500',
            'file:mr-4',
            'file:py-2',
            'file:px-4',
            'file:rounded-md',
            'file:border-0',
            'file:text-sm',
            'file:font-semibold',
            'file:bg-indigo-50',
            'file:text-indigo-700',
            'hover:file:bg-indigo-100',
        ])
    }}
/>
