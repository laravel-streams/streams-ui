<div
    {{
        $attributes->merge([
            'class' => $attributes->get('class', 'divide-y divide-gray-200 bg-white shadow ring-1 ring-black/5'),
        ])
    }}
>
    {{ $slot }}
</div>
