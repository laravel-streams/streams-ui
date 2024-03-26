@props([
    'fullHeight' => true,
])

<div {{ $this->getHtmlAttributeBag()->class([
    'ui-page',
    'h-full' => $fullHeight,
]) }}>
    {{ $slot }}
</div>
