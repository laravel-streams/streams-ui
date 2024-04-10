<x-ui::button
    tag="{{ $action->getTag() }}"
    href="{{ $action->getUrl() }}"
    color="{{ $action->getColor() }}"
    target="{{ $action->shouldOpenInNewTab() ? '_blank' : '_self' }}"
    :attributes="$action->getHtmlAttributeBag()"
    >
    {{ $action->getLabel() }}
</x-ui::button>
