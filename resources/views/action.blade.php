<x-ui::button
    tag="{{ $action->getTag() }}"
    href="{{ $action->getUrl() }}"
    :attributes="$action->getHtmlAttributeBag()"
    >
    {{ $action->getLabel() }}
</x-ui::button>
