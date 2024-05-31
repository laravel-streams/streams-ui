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
        <div class="flex flex-row-reverse gap-x-3 p-3">

            {{-- @if ($bulkActions)
            <div class="flex mr-12">
                @foreach ($bulkActions as $action)
                {!! $action->render() !!}
                @endforeach
            </div>
            @endif --}}

            @if ($filters)
            <div x-data="{open: true}" x-on:click.outside="open=false" x-on:keydown.escape.window="open=false" class="flex justify-center relative">

                <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-500">
                    <x-heroicon-c-funnel class="h-5 w-5" />
                </button>
            
                <x-ui::table.filters
                    {{-- :form="$getFiltersForm()" --}}
                    :filters="$filters"
                    x-cloak
                    x-show="open"
                    class="absolute top-full right-0 w-72 bg-white p-4 border rounded-lg shadow-md"/>
            </div>
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
