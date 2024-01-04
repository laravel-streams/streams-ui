@php
    $datalistOptions = $getDatalist();
    //$extraAlpineAttributes = $getExtraAlpineAttributes();
    $id = $getId();
    //$isConcealed = $isConcealed();
    $isDisabled = $isDisabled();
    // $isPrefixInline = $isPrefixInline();
    // $isSuffixInline = $isSuffixInline();
    $mask = $getMask();
    // $prefixActions = $getPrefixActions();
    // $prefixIcon = $getPrefixIcon();
    // $prefixLabel = $getPrefixLabel();
    // $suffixActions = $getSuffixActions();
    // $suffixIcon = $getSuffixIcon();
    // $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    {{-- <x-ui::inputs.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :prefix-icon-color="$getPrefixIconColor()"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :suffix-icon-color="$getSuffixIconColor()"
        :valid="! $errors->has($statePath)"
        class=""
        :attributes="
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class(['overflow-hidden'])
        "
    > --}}
    @props([
    'inlinePrefix' => false,
    'inlineSuffix' => false,
])

        <x-ui::inputs.input
            :attributes="new \Illuminate\View\ComponentAttributeBag([
                //'autocapitalize' => $getAutocapitalize(),
                'autocomplete' => $getAutocomplete(),
                'autofocus' => $isAutofocused(),
                'disabled' => $isDisabled,
                'id' => $id,
                // 'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                // 'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                'inputmode' => $getInputMode(),
                'list' => $datalistOptions ? $id . '-list' : null,
                'max' => $getMaxValue(),
                // 'max' => (! $isConcealed) ? $getMaxValue() : null,
                'maxlength' => $getMaxLength(),
                // 'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                'min' => $getMinValue(),
                // 'min' => (! $isConcealed) ? $getMinValue() : null,
                'minlength' => $getMinLength(),
                // 'minlength' => (! $isConcealed) ? $getMinLength() : null,
                'placeholder' => $getPlaceholder(),
                'readonly' => $isReadonly(),
                // 'required' => $isRequired() && (! $isConcealed),
                'required' => $isRequired(),
                'step' => $getStep(),
                'type' => blank($mask) ? $getType() : 'text',
                //$applyStateBindingModifiers('wire:model') => $statePath,
                'wire:model' => $statePath,
                // 'x-data' => (count($extraAlpineAttributes) || filled($mask)) ? '{}' : null,
                'x-data' => (filled($mask)) ? '{}' : null,
                // 'x-mask' . ($mask instanceof \Filament\Support\RawJs ? ':dynamic' : '') => filled($mask) ? $mask : null,
            ])"
        />
    {{-- </x-ui::inputs.wrapper> --}}

    @if ($datalistOptions)
        <datalist id="{{ $id }}-list">
            @foreach ($datalistOptions as $option)
                <option value="{{ $option }}" />
            @endforeach
        </datalist>
    @endif
</x-dynamic-component>
