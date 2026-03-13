@php
    $action = $this->getMountedAction();

    if (!$action && isset($this->table)) {
        $action = $this->getMountedTableAction();
    }

    if (!$action && isset($this->table)) {
        $action = $this->getMountedTableBulkAction();
    }
    
    if (!$action) {
        return;
    }
@endphp

<x-ui::modal
    :action="$action"
    :alignment="$action?->getModalAlignment()"
    :close-button="$action?->hasModalCloseButton()"
    :close-by-clicking-away="$action?->isModalClosedByClickingAway()"
    :description="$action?->getModalDescription()"
    {{-- display-classes="block" --}}
    :footer-actions="$action?->getVisibleModalFooterActions()"
    :footer-actions-alignment="$action?->getModalFooterActionsAlignment()"
    :heading="$action?->getModalHeading()"
    :icon="$action?->getModalIcon()"
    :icon-color="$action?->getModalIconColor()"
    :id="$action?->getId() . '-action'"
    {{-- :slide-over="$action?->isModalSlideOver()" --}}
    :sticky-footer="$action?->isModalFooterSticky()"
    :sticky-header="$action?->isModalHeaderSticky()"
    :visible="filled($action) && $action->shouldOpenModal()"
    :open="json_encode($action?->isModalOpen() ?: false)"
    :width="$action?->getModalWidth()"
    :wire:key="$action ? $this->getId() . '.actions.' . $action->getName() . '.modal' : null"
    x-on:modal-closed.stop="$wire.unmountAction(false);">
    @if ($action)
        {{ $action->getModalContent() }}
        @foreach ($action->getModalComponents() as $component)
        @if (is_string($component))
            @livewire($component)
        @else
            {!! $component->render() !!}
        @endif
        @endforeach
        {{ $action->getModalContentFooter() }}
    @endif
</x-ui::modal>
