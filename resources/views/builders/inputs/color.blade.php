@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $borderRadius = $getBorderRadius() ?? 'md';
    $placeholder = $getPlaceholder() ?: '#000000';
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" class="flex">
    <div class="flex w-full items-center gap-2">
        <input
            type="color"
            @disabled($isDisabled)
            wire:model="{{ $statePath }}"
            aria-label="{{ $getLabel() }}"
            class="{{ implode(' ', [
                'h-10 w-10 shrink-0 cursor-pointer border-0 bg-transparent p-0',
                "rounded-{$borderRadius}",
                '[&::-webkit-color-swatch-wrapper]:p-0',
                "[&::-webkit-color-swatch]:rounded-{$borderRadius}",
                '[&::-webkit-color-swatch]:border-0',
                "[&::-moz-color-swatch]:rounded-{$borderRadius}",
                '[&::-moz-color-swatch]:border-0',
                'disabled:cursor-not-allowed disabled:opacity-50',
            ]) }}"
        />

        <x-ui::inputs.input
            :attributes="(new \Illuminate\View\ComponentAttributeBag([
                'autocomplete' => 'off',
                'borderRadius' => $borderRadius,
                'disabled' => $isDisabled,
                'id' => $id,
                'placeholder' => $placeholder,
                'required' => $isRequired(),
                'spellcheck' => 'false',
                'type' => 'text',
                'wire:model' => $statePath,
            ]))->merge($getHtmlAttributes())"
        />
    </div>
</x-dynamic-component>
