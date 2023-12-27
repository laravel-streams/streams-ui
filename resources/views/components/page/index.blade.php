@props([
'actions' => [],
'heading' => null,
'subheading' => null,
'page' => null,
])

<div {{ $attributes->class(['w-full', 'p-4']) }}>

    @if ($actions || $heading || $subheading)
    <x-ui::header :actions="$actions" :breadcrumbs="[]" :heading="$heading" :subheading="$subheading" headingSize="text-2xl" subheadingSize="text-md" />
    @endif
    
    {{ $slot }}
</div>
