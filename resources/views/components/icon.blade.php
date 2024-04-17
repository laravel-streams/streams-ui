@props([
    'alias' => null,
    'class' => 'h-6 w-6',
    'icon' => null,
])

@php
    $icon = ($alias ? $alias : null) ?: $icon;
@endphp

@if ($icon instanceof \Illuminate\Contracts\Support\Htmlable)
    <div {{ $attributes->class($class) }}>
        {{ $icon ?? $slot }}
    </div>
@elseif (str_contains($icon, '/'))
    <img
        {{
            $attributes
                ->merge(['src' => $icon])
                ->class($class)
        }}
    />
@else
    @svg(
        $icon,
        $class,
        array_filter($attributes->getAttributes()),
    )
@endif
