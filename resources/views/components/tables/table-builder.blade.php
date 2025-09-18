@props([
    'id' => null,
    'component' => null,
    'htmlAttributes' => null,
])

<div 
    @if($id) id="{{ $id }}" @endif
    @if($htmlAttributes) {{ $htmlAttributes }} @endif
    class="{{ $attributes->get('class', '') }}"
    {{ $attributes->except(['class']) }}
>
    @if($component)
        @livewire($component::class, [], key($component->getId()))
    @endif
</div>
