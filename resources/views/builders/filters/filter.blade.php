<x-ui::inputs.input id="{{ $filter->getName() }}-filter"
    name="{{ $path = $filter->getName() . '-filter' }}" value="{{ Request::get($path) }}"
    placeholder="{{ $filter->getPlaceholder() }}" wire:model.live.debounce.200ms="tableFilters.{{ $filter->getName() }}.value"/>
