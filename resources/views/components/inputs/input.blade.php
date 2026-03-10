@props([
    'inlinePrefix' => false,
    'inlineSuffix' => false,
])

@php
    $isReadonly = $attributes->get('readonly', false);
@endphp

<input
    {{
        $attributes->class([
            'block',
            'w-full',
            'rounded-md',
            'px-3 py-2',
            'ps-0' => $inlinePrefix,
            'ps-3' => ! $inlinePrefix,
            'pe-0' => $inlineSuffix,
            'pe-3' => ! $inlineSuffix,
            'bg-gray-50 text-gray-600 cursor-default select-none' => $isReadonly,
        ])
    }}
/>
