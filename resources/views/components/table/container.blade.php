@props([
    'borderRadiusClass' => null,
])

<div
    {{
        $attributes
            ->class([
                'divide-y divide-gray-200 bg-white shadow ring-1 ring-black/5',
                $borderRadiusClass,
            ])
    }}
>
    {{ $slot }}
</div>
