<x-ui::fieldset
    :label="$getLabel()"
    {{-- :label-hidden="$isLabelHidden()" --}}
    :attributes="
        // \Filament\Support\prepare_inherited_attributes($attributes)
        $attributes
            ->merge([
                'id' => $getId(),
            ], escape: false)
            ->merge($getHtmlAttributes(), escape: false)
    "
>
    {{-- {{ $getChildComponentContainer() }} --}}
    @foreach ($getComponents() as $component)
        {{ $component }}
    @endforeach
</x-ui::fieldset>
