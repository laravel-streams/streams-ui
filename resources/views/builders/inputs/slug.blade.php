@php
    $datalistOptions = $getDatalist();
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $borderRadius = $getBorderRadius() ?? 'md';
    $slugifyStatePath = $getSlugifyStatePath();
    $separator = $getSeparator();
    $followSource = $shouldSyncSlugify();
@endphp

{{--
  Alpine owns the visible value via $wire.entangle (same pattern as toggle).
  Deferred entangle syncs FROM Livewire on init/hydrate and TO Livewire on change
  without an immediate network re-render, so typing is not wiped by morphs.
--}}
<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" class="flex">
    <div
        class="w-full"
        x-data="{
            value: $wire.entangle('{{ $statePath }}'),
            separator: @js($separator),
            sourcePath: @js($slugifyStatePath),
            followSource: @js($followSource),
            slugify(raw) {
                const sep = this.separator;

                return String(raw ?? '')
                    .toLowerCase()
                    .replace(/ /g, sep)
                    .replace(new RegExp('[^\\w' + sep.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ']+', 'g'), '')
                    .replace(new RegExp(sep.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + '+', 'g'), sep);
            },
            applySlug(raw) {
                this.value = this.slugify(raw);
            },
            onSlugInput() {
                this.followSource = this.value === '';
                this.applySlug(this.value);
            },
            onSourceInput(raw) {
                if (! this.followSource) {
                    return;
                }

                this.applySlug(raw);
            },
        }"
        x-init="
            if (value) {
                followSource = false;
            }

            if (! sourcePath) {
                return;
            }

            const source = document.getElementById(sourcePath);

            if (! source) {
                return;
            }

            source.addEventListener('input', (event) => onSourceInput(event.target.value));
        "
    >
        <x-ui::inputs.input
            :attributes="new \Illuminate\View\ComponentAttributeBag([
                'autocomplete' => $getAutocomplete(),
                'borderRadius' => $borderRadius,
                'autofocus' => $isAutofocused(),
                'disabled' => $isDisabled,
                'id' => $id,
                'inputmode' => $getInputMode(),
                'list' => $datalistOptions ? $id . '-list' : null,
                'max' => $getMaxValue(),
                'maxlength' => $getMaxLength(),
                'min' => $getMinValue(),
                'minlength' => $getMinLength(),
                'placeholder' => $getPlaceholder(),
                'readonly' => $isReadonly(),
                'required' => $isRequired(),
                'step' => $getStep(),
                'type' => $getType() ?? 'text',
                'x-model' => 'value',
                'x-on:input' => 'onSlugInput()',
            ])->merge($getHtmlAttributes())"
        />
    </div>

    @if ($datalistOptions)
        <datalist id="{{ $id }}-list">
            @foreach ($datalistOptions as $option)
                <option value="{{ $option }}" />
            @endforeach
        </datalist>
    @endif
</x-dynamic-component>
