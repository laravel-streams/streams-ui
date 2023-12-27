<x-ui::inputs.native-select
    id="{{ $filter->getName() }}-filter"
    name="{{ $path = $filter->getName() . '-filter' }}"
    onchange="this.form.submit()">
    
    <option value="">Status</option>

    @foreach ($filter->getOptions() as $key => $value)
    <option {{ Request::get($path)==$key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
    @endforeach
    
</x-ui::input.select>
