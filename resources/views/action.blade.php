<x-ui::action
    :tag="$action->getTag()"
    :href="$action->getUrl()"
    :icon="$action->getIcon()"
    :color="$action->getColor()"
    :style="$action->getStyle()"
    :tooltip="$action->getTooltip()"
    :disabled="$action->isDisabled()"
    :keyBindings="$action->getKeyBindings()"
    :borderRadius="$action->getBorderRadius()"
    target="{{ $action->shouldOpenInNewTab() ? '_blank' : '_self' }}"
    :attributes="$action->getHtmlAttributeBag()"
    :openInNewTab="$action->shouldOpenInNewTab()"
    >
    {{ $action->getLabel() }}
</x-ui::action>
