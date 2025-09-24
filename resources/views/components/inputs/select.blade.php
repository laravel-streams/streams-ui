@php
    //$canSelectPlaceholder = $canSelectPlaceholder();
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

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" class="flex">
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
        :attributes="\Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())"
    > --}}
        {{-- @if ((! ($isSearchable() || $isMultiple()) && $isNative())) --}}
            <x-ui::inputs.native-select
                {{-- :autofocus="$isAutofocused()" --}}
                :disabled="$isDisabled"
                :id="$getId()"
                {{-- :inline-prefix="$isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel))" --}}
                {{-- :inline-suffix="$isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel))" --}}
                {{-- :required="$isRequired() && ((bool) $isConcealed())" --}}
                :required="$isRequired()"
                :attributes="
                    (new \Illuminate\View\ComponentAttributeBag())
                        ->merge([
                            //$applyStateBindingModifiers('wire:model') => $statePath,
                            'multiple' => $isMultiple(),
                        ], escape: false)
                "
            >
                @php
                    $isHtmlAllowed = false;//$isHtmlAllowed();
                @endphp

                {{-- @if ($canSelectPlaceholder) --}}
                @if ($placeholder = $getPlaceholder())
                    <option value="">
                        @if (!$isDisabled)
                            {{ $placeholder() }}
                        @endif
                    </option>
                @endif

                @foreach ($getOptions() as $value => $label)
                    @if (is_array($label))
                        <optgroup label="{{ $value }}">
                            @foreach ($label as $groupedValue => $groupedLabel)
                                <option
                                    {{-- @disabled($isOptionDisabled($groupedValue, $groupedLabel)) --}}
                                    value="{{ $groupedValue }}"
                                >
                                    @if ($isHtmlAllowed)
                                        {!! $groupedLabel !!}
                                    @else
                                        {{ $groupedLabel }}
                                    @endif
                                </option>
                            @endforeach
                        </optgroup>
                    @else
                        <option
                            {{-- @disabled($isOptionDisabled($value, $label)) --}}
                            value="{{ $value }}"
                        >
                            @if ($isHtmlAllowed)
                                {!! $label !!}
                            @else
                                {{ $label }}
                            @endif
                        </option>
                    @endif
                @endforeach
            </x-ui::input.select>

        {{-- @endif --}}
    {{-- </x-ui::inputs.wrapper> --}}
</x-dynamic-component>
