@php
    // $isAside = $isAside();
@endphp

<x-ui::section
    {{-- :aside="$isAside" --}}
    {{-- :collapsed="$isCollapsed()" --}}
    {{-- :collapsible="$isCollapsible() && (! $isAside)" --}}
    {{-- :compact="$isCompact()" --}}
    {{-- :content-before="$isFormBefore()" --}}
    :description="$getDescription()"
    :heading="$getHeading()"
    {{-- :icon="$getIcon()"
    :icon-color="$getIconColor()"
    :icon-size="$getIconSize()" --}}
    :attributes="
        // \Filament\Support\prepare_inherited_attributes($attributes)
        (new \Illuminate\View\ComponentAttributeBag)
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getHtmlAttributes(), escape: false)
            // ->merge($getExtraAlpineAttributes(), escape: false)
    "
>
    {{ $getComponentContainer() }}
    {{-- @foreach ($getComponents(true) as $component)
        {{ $component }}
    @endforeach --}}
</x-ui::section>
