<x-ui::action
    :tag="$getTag()"
    :href="$getUrl()"
    :icon="$getIcon()"
    :size="$getSize()"
    :color="$getColor()"
    :style="$getStyle()"
    :tooltip="$getTooltip()"
    :disabled="$isDisabled()"
    :keyBindings="$getKeyBindings()"
    :borderRadius="$getBorderRadius()"
    target="{{ $shouldOpenInNewTab() ? '_blank' : '_self' }}"
    :attributes="$getHtmlAttributeBag()->merge([
        'x-data' => '{ copied: false }',
        'x-on:click' => 'navigator.clipboard.writeText(`' . addslashes($getContent()) . '`).then(() => { copied = true; setTimeout(() => copied = false, 2000); })',
        'type' => 'button'
    ])"
    :openInNewTab="$shouldOpenInNewTab()"
    >
    <span x-show="!copied">{{ $getLabel() }}</span>
    <span x-show="copied" x-cloak>Copied!</span>
</x-ui::action>
