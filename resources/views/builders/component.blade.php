@props([
    'component' => null,
])

@php
    $livewireComponent = $component ? $component->getLivewireComponent() : null;
@endphp

<div {{ $attributes }}>
    @if($livewireComponent && is_string($livewireComponent))
        @livewire($livewireComponent)
    @elseif($livewireComponent)
        {{ $livewireComponent }}
    @endif
</div>
