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

    $spacingAxis = $container->isColumnDirection() ? 'space-y' : 'space-x';

    $spacingClasses = match ($container->getSpacing() ?? 's') {
        'xs' => "{$spacingAxis}-2",
        's' => "{$spacingAxis}-4",
        'm' => "{$spacingAxis}-6",
        'l' => "{$spacingAxis}-8",
        'xl' => "{$spacingAxis}-10",
        '2xl' => "{$spacingAxis}-12",
        default => "{$spacingAxis}-4",
    };

    $classes = Arr::toCssClasses([
        '',
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);

    $backgroundStyles = array_fill_keys($container->getBackgroundStyles(), true);

    $borderRadiusClass = $container->getBorderRadiusClass();

    $insetClass = $container->getInsetClass();

@endphp
<div {!!
    $attributes
        ->class([
            'flex',
            $container->isColumnDirection() ? 'flex-col' : 'flex-row',
            $spacingClasses,
            $insetClass,
            $borderRadiusClass,
            'col-[--col-span-default]' => $columnSpan['default'] ?? null,
            'sm:col-[--col-span-sm]' => $columnSpan['sm'] ?? null,
            'md:col-[--col-span-md]' => $columnSpan['md'] ?? null,
            'lg:col-[--col-span-lg]' => $columnSpan['lg'] ?? null,
            'xl:col-[--col-span-xl]' => $columnSpan['xl'] ?? null,
            '2xl:col-[--col-span-2xl]' => $columnSpan['2xl'] ?? null,
            $container->getHtmlAttributes()['class'] ?? null,
        ])
        ->style([
            "--col-span-default: {$getSpanValue($columnSpan['default'])}" => $columnSpan['default'] ?? null,
            "--col-span-sm: {$getSpanValue($columnSpan['sm'])}" => $columnSpan['sm'] ?? null,
            "--col-span-md: {$getSpanValue($columnSpan['md'])}" => $columnSpan['md'] ?? null,
            "--col-span-lg: {$getSpanValue($columnSpan['lg'])}" => $columnSpan['lg'] ?? null,
            "--col-span-xl: {$getSpanValue($columnSpan['xl'])}" => $columnSpan['xl'] ?? null,
            "--col-span-2xl: {$getSpanValue($columnSpan['2xl'])}" => $columnSpan['2xl'] ?? null,
            ...$backgroundStyles,
        ])
        ->merge($container->getHtmlAttributes())
!!}>

    @foreach ($container->getComponents() as $component)
    {{ $component }}
    @endforeach
</div>
