@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $borderRadius = $getBorderRadius() ?? 'md';
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" class="flex">
    <x-ui::inputs.input
        :attributes="(new \Illuminate\View\ComponentAttributeBag([
            'autocomplete' => 'off',
            'borderRadius' => $borderRadius,
            'disabled' => $isDisabled,
            'id' => $id,
            'placeholder' => $getPlaceholder(),
            'required' => $isRequired(),
            'type' => 'color',
            'wire:model' => $statePath,
        ]))->merge($getHtmlAttributes())"
    />
</x-dynamic-component>
