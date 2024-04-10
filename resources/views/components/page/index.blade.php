@props([
'fullHeight' => true,
])

<div {{ $this->getHtmlAttributeBag()->class([
    'ui-page',
    'h-full' => $fullHeight,
    ]) }}>
    {{ $slot }}

    <x-ui::modals />

</div>
