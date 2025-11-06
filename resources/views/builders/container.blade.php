@php
    $columnSpan = $getColumnSpan();

    if (! is_array($columnSpan)) {
        $columnSpan = [
            'default' => $columnSpan,
        ];
    }

    $getSpanValue = function ($span): string {
        
        if ($span === 'full') {
            return '1 / -1';
        }

        return "span {$span} / span {$span}";
    };

    $classes = Arr::toCssClasses([
        '',
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);

@endphp
<div {{
    $attributes
        ->class([
            'flex flex-col space-y-4',
            'col-[--col-span-default]' => $columnSpan['default'] ?? null,
            'sm:col-[--col-span-sm]' => $columnSpan['sm'] ?? null,
            'md:col-[--col-span-md]' => $columnSpan['md'] ?? null,
            'lg:col-[--col-span-lg]' => $columnSpan['lg'] ?? null,
            'xl:col-[--col-span-xl]' => $columnSpan['xl'] ?? null,
            '2xl:col-[--col-span-2xl]' => $columnSpan['2xl'] ?? null,
        ])
        ->style([
            "--col-span-default: {$getSpanValue($columnSpan['default'])}" => $columnSpan['default'] ?? null,
            "--col-span-sm: {$getSpanValue($columnSpan['sm'])}" => $columnSpan['sm'] ?? null,
            "--col-span-md: {$getSpanValue($columnSpan['md'])}" => $columnSpan['md'] ?? null,
            "--col-span-lg: {$getSpanValue($columnSpan['lg'])}" => $columnSpan['lg'] ?? null,
            "--col-span-xl: {$getSpanValue($columnSpan['xl'])}" => $columnSpan['xl'] ?? null,
            "--col-span-2xl: {$getSpanValue($columnSpan['2xl'])}" => $columnSpan['2xl'] ?? null,
        ])
}}>
    @foreach ($container->getComponents() as $component)
    {{ $component }}
    @endforeach
</div>
