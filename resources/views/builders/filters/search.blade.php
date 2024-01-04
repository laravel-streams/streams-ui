@props([
    'wireModel' => 'tableSearch',
])

<x-ui::inputs.input
    id="{{ $filter->getName() }}-filter"
    name="{{ $path = $filter->getName() . '-filter' }}"
    placeholder="Search"
    wire:model.live.debounce.500ms="tableSearch"
    :wire:target="$wireModel"
    x-bind:id="$id('input')"
    :attributes="(new \Illuminate\View\ComponentAttributeBag([
                //'autocapitalize' => $getAutocapitalize(),
                //'autocomplete' => $getAutocomplete(),
                'autofocus' => $isAutofocused(),
            ]))->merge($filter->getHtmlAttributes())"
    />
