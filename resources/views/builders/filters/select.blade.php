<x-ui::inputs.native-select
    id="{{ $filter->getName() }}-filter"
    name="{{ $path = $filter->getName() . '-filter' }}"
    {{-- onchange="this.form.submit()" --}}
    wire:model.live="tableFilters.{{ $filter->getName() }}.value"
    required>
    
    <option {{ $filter->isRequired() ? 'disabled' : null }} value="">{{ $filter->getPlaceholder() ?: Str::title($filter->getName()) }}</option>

    @foreach ($filter->getOptions() as $key => $value)
    <option {{ Request::get($path)==$key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
    @endforeach
    
</x-ui::input.select>
