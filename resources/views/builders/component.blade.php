@props([
    'component' => null,
])

@php
    $livewireComponent = $component ? $component->getLivewireComponent() : null;
@endphp

<div {{ $attributes }}>
    @if($livewireComponent)
        @livewire($livewireComponent)
    @endif
</div>
