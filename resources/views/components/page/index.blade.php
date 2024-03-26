@props([
    'fullHeight' => true,
])

<div {{ $attributes->class([
    'ui-page',
    'h-full' => $fullHeight,
]) }}>
    {{ $slot }}
</div>
