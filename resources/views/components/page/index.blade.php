@props([
    'fullHeight' => true,
    'class' => null,
])

<div class="{{ $class }}">

    {{ $slot }}

    <x-ui::modals />
    <x-ui::messages />

</div>
