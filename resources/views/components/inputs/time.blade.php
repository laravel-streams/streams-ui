@php
    $datalistOptions = $getDatalist();
    //$extraAlpineAttributes = $getExtraAlpineAttributes();
    $id = $getId();
    $isDisabled = $isDisabled();
    // $isPrefixInline = $isPrefixInline();
    // $isSuffixInline = $isSuffixInline();
    // $prefixActions = $getPrefixActions();
    // $prefixIcon = $getPrefixIcon();
    // $prefixLabel = $getPrefixLabel();
    // $suffixActions = $getSuffixActions();
    // $suffixIcon = $getSuffixIcon();
    // $suffixLabel = $getSuffixLabel();
    $statePath = $getStatePath();
@endphp

{{-- <x-dynamic-component :component="$getFieldWrapperView()" :field="$field"> --}}
    {{-- <x-filament::input.wrapper
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
        :attributes="\Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())"
    > --}}
        {{-- @if ($isNative()) --}}
        @if (true)
            <x-ui::inputs.input
                :attributes="
                    // \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                    (new \Illuminate\View\ComponentAttributeBag)
                        // ->merge($extraAlpineAttributes, escape: false)
                        ->merge([
                            // 'autofocus' => $isAutofocused(),
                            'disabled' => $isDisabled,
                            'id' => $id,
                            // 'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                            // 'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                            'list' => $datalistOptions ? $id . '-list' : null,
                            // 'max' => (! $isConcealed) ? $getMaxDate() : null,
                            // 'min' => (! $isConcealed) ? $getMinDate() : null,
                            'max' => $getMaxTime() ?: null,
                            'min' => $getMinTime() ?: null,
                            'placeholder' => $getPlaceholder(),
                            'readonly' => $isReadonly(),
                            'required' => $isRequired() && (! $isConcealed),
                            'step' => $getStep(),
                            'type' => 'time',
                            // $applyStateBindingModifiers('wire:model') => $statePath,
                            // 'x-data' => count($extraAlpineAttributes) ? '{}' : null,
                        ], escape: false)
                "
            />
        @else
            {{-- Load non-native --}}
        @endif
    {{-- </x-filament::input.wrapper> --}}

    @if ($datalistOptions)
        <datalist id="{{ $id }}-list">
            @foreach ($datalistOptions as $option)
                <option value="{{ $option }}" />
            @endforeach
        </datalist>
    @endif
{{-- </x-dynamic-component> --}}
