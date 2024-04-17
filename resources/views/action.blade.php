<x-ui::action
    :tag="$action->getTag()"
    :href="$action->getUrl()"
    :icon="$action->getIcon()"
    :color="$action->getColor()"
    :style="$action->getStyle()"
    :disabled="$action->isDisabled()"
    :keyBindings="$action->getKeyBindings()"
    target="{{ $action->shouldOpenInNewTab() ? '_blank' : '_self' }}"
    :attributes="$action->getHtmlAttributeBag()"
    >
    {{ $action->getLabel() }}
</x-ui::action>
