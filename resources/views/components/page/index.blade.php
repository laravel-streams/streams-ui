@props([
'fullHeight' => true,
])

<div>
    {{ $slot }}

    <x-ui::modals />

</div>
