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

{!! Assets::inline(base_path('/vendor/streams/ui/resources/js/components/table.js')) !!}

<div
    x-data="table()"
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

        @if ($bulkActions || $filters)
        <div class="flex gap-x-3 p-3">

            {{-- @if ($bulkActions)
            <div class="flex mr-12">
                @foreach ($bulkActions as $action)
                {!! $action->render() !!}
                @endforeach
            </div>
            @endif --}}

            @if ($filters)
            {{-- <form method="get" class="flex gap-x-3"> --}}
                @foreach ($filters as $filter)
                <div class="flex items-center w-xl">
                    {!! $filter->render() !!}
                </div>
                @endforeach

                {{-- <x-ui::action type="submit" :class="'hidden'">Submit</x-ui::action>

                <x-ui::action tag="a" href="{{ url()->current() }}" :class="'bg-red-500'">Clear</x-ui::action> --}}

            {{-- </form> --}}
            @endif
            
        </div>
        @endif

        <table class="min-w-full divide-y divide-gray-200">

            <x-ui::table.head :table="$table" :columns="$columns" :actions="$actions" :bulkActions="$bulkActions" />

            <tbody class="divide-y divide-gray-200 bg-white">

                @foreach ($paginator as $entry)
                @php
                    $entryUrl = $getEntryUrl($entry);
                @endphp
                <x-ui::table.row :table="$table" :entry="$entry" :columns="$columns" :actions="$actions"
                    :bulkActions="$bulkActions" :entryUrl="$entryUrl" />
                @endforeach

            </tbody>

            <x-ui::table.foot :table="$table" :paginator="$paginator" :paginationOptions="$paginationOptions"/>

        </table>

    </x-ui::table.container>

</div>
