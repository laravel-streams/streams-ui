{{-- <x-dynamic-component :component="$getFieldWrapperView()" :field="$field"> --}}
@php
    $statePath = $getStatePath();
@endphp

<x-ui::inputs.native-checkbox
    :error="$errors->has($statePath)"
    :label="$getLabel()"
    :attributes="
        $attributes
            ->merge([
                //'autofocus' => $isAutofocused(),
                'disabled' => $isDisabled(),
                'id' => $getId(),
                'required' => $isRequired() && (! $isConcealed()),
                'wire:loading.attr' => 'disabled',
                //$applyStateBindingModifiers('wire:model') => $statePath,
            ], escape: false)
            //->merge($getExtraAttributes(), escape: false)
            //->merge($getExtraInputAttributes(), escape: false)
    "
/>
{{-- </x-dynamic-component> --}}
