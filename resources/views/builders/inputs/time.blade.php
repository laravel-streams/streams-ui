@php
    $datalistOptions = $getDatalist();
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $borderRadius = $getBorderRadius() ?? 'md';
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-ui::inputs.input
        :attributes="
            (new \Illuminate\View\ComponentAttributeBag)
                ->merge([
                    'disabled' => $isDisabled,
                    'autocomplete' => $getAutocomplete(),
                    'borderRadius' => $borderRadius,
                    'id' => $id,
                    'list' => $datalistOptions ? $id . '-list' : null,
                    'max' => $getMaxTime() ?: null,
                    'min' => $getMinTime() ?: null,
                    'placeholder' => $getPlaceholder(),
                    'readonly' => $isReadonly(),
                    'required' => $isRequired(),
                    'step' => $getStep(),
                    'type' => 'time',
                    'wire:model' => $statePath,
                ], escape: false)
                ->merge($getHtmlAttributes())
        "
    />

    @if ($datalistOptions)
        <datalist id="{{ $id }}-list">
            @foreach ($datalistOptions as $option)
                <option value="{{ $option }}" />
            @endforeach
        </datalist>
    @endif
</x-dynamic-component>
