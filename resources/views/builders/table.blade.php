@php
$actions = $table->getActions();
$columns = $table->getColumns();
$filters = $table->getFilters();
$bulkActions = $table->getBulkActions();

$paginator = $this->getTableEntries();

$heading = $table->getHeading();
$description = $table->getDescription();
$headerActions = [];//$table->getHeaderActions();

$paginationOptions = $table->getPaginationOptions();

$selectedRecords = [];

@endphp

<div
    x-data="{
        selectedRecords: {{ json_encode($selectedRecords) }},
        toggleSelectAllRecords: function () {
            let records = this.getRecords();
            if (this.areRecordsSelected(records)) {
                this.deselectRecords(records);
                return;
            }
            this.selectRecords(records);
        },
        getRecords: function () {
            
            let records = [];

            for (let checkbox of this.$root.getElementsByClassName('ui-table-row-checkbox')) {
                records.push(checkbox.value);
            }
            return records;
        },
        selectRecords: function (records) {
            for (let record of records) {
                if (!this.isRecordSelected(record)) {
                    this.selectedRecords.push(record);
                }
            }
        },
        deselectRecords: function (records) {
            for (let record of records) {
                let index = this.selectedRecords.indexOf(record);
                if (index !== -1) {
                    this.selectedRecords.splice(index, 1);
                }
            }
        },
        isRecordSelected: function (record) {
            return this.selectedRecords.includes(record);
        },
        areRecordsSelected: function (records) {
            return records.every(record => this.isRecordSelected(record));
        },
    }"
    {{-- @if (! $isLoaded)
        wire:init="loadTable"
    @endif --}}
    {{-- @if (FilamentView::hasSpaMode())
        ax-load="visible"
    @else
        ax-load
    @endif --}}
    {{-- ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('table', 'filament/tables') }}" --}}>

    <x-ui::table.container>

        @if ($heading || $description || $headerActions)
        <x-ui::table.header :heading="$heading" :description="$description" :actions="$headerActions" />
        @endif

        <div class="flex gap-x-3 p-3">

            @if ($bulkActions)
            <div class="flex mr-12">
                @foreach ($bulkActions as $action)
                {!! $action->render() !!}
                @endforeach
            </div>
            @endif

            @if ($filters)
            {{-- <form method="get" class="flex gap-x-3"> --}}
                @foreach ($filters as $filter)
                <div class="flex items-center w-xl">
                    {!! $filter->render() !!}
                </div>
                @endforeach

                {{-- <x-ui::button type="submit" :class="'hidden'">Submit</x-ui::button>

                <x-ui::button tag="a" href="{{ url()->current() }}" :class="'bg-red-500'">Clear</x-ui::button> --}}

            {{-- </form> --}}
            @endif

        </div>

        <table class="min-w-full divide-y divide-gray-200">

            <x-ui::table.head :table="$table" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" />

            <tbody class="divide-y divide-gray-200 bg-white">

                @foreach ($paginator as $entry)
                <x-ui::table.row :table="$table" :entry="$entry" :columns="$columns" :actions="$actions"
                    :bulkActions="$bulkActions" />
                @endforeach

            </tbody>

            <x-ui::table.foot :table="$table" :paginator="$paginator" :paginationOptions="$paginationOptions"/>

        </table>

    </x-ui::table.container>

</div>
