@props([
    'wireModel' => null,
])

<x-ui::inputs.input
    id="{{ $filter->getName() }}-filter"
    name="{{ $path = $filter->getName() . '-filter' }}"
    placeholder="Search"
    wire:key="$id('input')"
    :wire:change="'setTableSearch(\''.$filter->getTable()->getName().'\', $event.target.value)'"
    :attributes="(new \Illuminate\View\ComponentAttributeBag([
                //'autocapitalize' => $getAutocapitalize(),
                //'autocomplete' => $getAutocomplete(),
                'autofocus' => $isAutofocused(),
            ]))->merge($filter->getHtmlAttributes())"
    />
