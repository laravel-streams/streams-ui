@php
    // $isConcealed = $isConcealed();
    $rows = $getRows();
    $statePath = $getStatePath();
    $borderRadius = $getBorderRadius() ?? 'md';
    // $shouldAutosize = $shouldAutosize();

    $initialHeight = (($rows ?? 2) * 1.5) + 0.75;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <textarea
        {{-- @if ($shouldAutosize)
            ax-load
            ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('textarea', 'filament/forms') }}"
            x-data="textareaFormComponent({ initialHeight: @js($initialHeight) })"
            x-ignore
            x-intersect.once="render()"
            x-on:input="render()"
            x-on:resize.window="render()"
            style="height: {{ $initialHeight }}rem"
            {{ $getExtraAlpineAttributeBag() }}
        @endif --}}
        {{
            $attributes
                ->merge([
                    'autocomplete' => $getAutocomplete(),
                    // 'autofocus' => $isAutofocused(),
                    'cols' => $getColumns(),
                    'disabled' => $isDisabled(),
                    'id' => $getId(),
                    // 'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                    // 'minlength' => (! $isConcealed) ? $getMinLength() : null,
                    'maxlength' => $getMaxLength() ?: null,
                    'minlength' => $getMinLength() ?: null,
                    'placeholder' => $getPlaceholder(),
                    'readonly' => $isReadonly(),
                    // 'required' => $isRequired() && (! $isConcealed),
                    'required' => $isRequired(),
                    'rows' => $rows,
                    'wire:model' => $statePath,
                ], escape: false)
                ->merge($getHtmlAttributes(), escape: false)
                // ->merge($getExtraInputAttributes(), escape: false)
                ->class([
                    'block w-full px-3 py-2',
                    "rounded-{$borderRadius}",
                    // 'resize-none' => $shouldAutosize,
                ])
        }}
    ></textarea>
</x-dynamic-component>
