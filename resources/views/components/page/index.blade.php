@props([
'fullHeight' => true,
'class' => null,
])

<div class="{{ $class }}">
    
    {{ $slot }}

    <x-ui::modals />

</div>
