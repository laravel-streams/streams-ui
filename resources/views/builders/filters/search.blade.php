@props([
    'wireModel' => 'tableSearch',
])

<x-ui::inputs.input
    id="{{ $filter->getName() }}-filter"
    name="{{ $path = $filter->getName() . '-filter' }}"
    placeholder="Search"
    wire:key="$id('input')"
    :wire:target="$wireModel"
    :wire:model.live.debounce.500ms="$wireModel"
    :attributes="(new \Illuminate\View\ComponentAttributeBag([
                //'autocapitalize' => $getAutocapitalize(),
                //'autocomplete' => $getAutocomplete(),
                'autofocus' => $isAutofocused(),
            ]))->merge($filter->getHtmlAttributes())"
    />
