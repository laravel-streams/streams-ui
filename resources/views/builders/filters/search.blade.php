<x-ui::inputs.input
    id="{{ $filter->getName() }}-filter"
    name="{{ $path = $filter->getName() . '-filter' }}"
    value="{{ Request::get($path) }}"
    placeholder="Search"
    :attributes="(new \Illuminate\View\ComponentAttributeBag([
                //'autocapitalize' => $getAutocapitalize(),
                //'autocomplete' => $getAutocomplete(),
                'autofocus' => $isAutofocused(),
            ]))->merge($filter->getHtmlAttributes())"
    />
