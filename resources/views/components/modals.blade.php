@php
    $action = $this->getMountedAction();

    if (! $action && method_exists($this, 'getMountedTableAction')) {
        $action = $this->getMountedTableAction();
    }

    if (! $action && method_exists($this, 'getMountedTableBulkAction')) {
        $action = $this->getMountedTableBulkAction();
    }

    // Page actions dispatch open-modal with getId(); older markup appended "-action"
    // and relied on isModalOpen() (always false unless set). Open from mount state so
    // the dialog appears even when the Livewire open event races teleport/Alpine init.
    $modalId = $action?->getId();
    $shouldOpen = filled($action) && $action->shouldOpenModal();

@endphp
<div>
    @if ($action)
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
        :id="$modalId"
        {{-- :slide-over="$action?->isModalSlideOver()" --}}
        :sticky-footer="$action?->isModalFooterSticky()"
        :sticky-header="$action?->isModalHeaderSticky()"
        {{-- :visible="filled($action) && $action->shouldOpenModal()" --}}
        {{-- :open="json_encode($action?->isModalOpen() ?: false)" --}}
        :visible="$shouldOpen"
        :open="$shouldOpen"
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
    @endif
</div>
