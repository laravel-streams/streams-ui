<x-ui::action
    :tag="$action->getTag()"
    :href="$action->getUrl()"
    :icon="$action->getIcon()"
    :size="$action->getSize()"
    :color="$action->getColor()"
    :style="$action->getStyle()"
    :tooltip="$action->getTooltip()"
    :disabled="$action->isDisabled()"
    :keyBindings="$action->getKeyBindings()"
    :borderRadius="$action->getBorderRadius()"
    target="{{ $action->shouldOpenInNewTab() ? '_blank' : '_self' }}"
    :attributes="$action->getHtmlAttributeBag()"
    :openInNewTab="$action->shouldOpenInNewTab()"
    :loadingIndicator="$action->getLoadingIndicator()"
    :loadingText="$action->getLoadingText()"
    >
    {{ $action->getLabel() }}
</x-ui::action>
