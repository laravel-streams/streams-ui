@props([
    'fullHeight' => true,
    'class' => null,
])

<div class="{{ $class }}">

    {{ $slot }}

</div>
