@php

$actions = $table->getActions();
$columns = $table->getColumns();
$filters = $table->getFilters();
$views = $table->getTableViews();
$bulkActions = $table->getBulkActions();
$tableName = $table->getName();

$hasActiveFilters = $table->hasActiveFilters();

// Visible columns only.
$columns = collect($columns)->filter(fn ($column) => $column->isVisible());

$paginator = $table->getEntries();

$heading = $table->getHeading();
$description = $table->getDescription();
$headerActions = $table->getHeaderActions();

$isPaginated = $table->isPaginated();
$paginationOptions = $table->getPaginationOptions();

$selectedStatePath = $table->getStatePath() . '.selected';

$borderRadiusClass = $table->getBorderRadiusClass();
$borderRadiusCss = $table->getBorderRadiusCssValue();
$hasHeaderChrome = filled($heading) || filled($description) || filled($headerActions);
$hasToolbarChrome = filled($bulkActions) || filled($filters) || filled($views);
$roundTopCorners = ! $hasHeaderChrome && ! $hasToolbarChrome;
$topLeftRadiusStyle = ($roundTopCorners && $borderRadiusCss) ? "border-top-left-radius: {$borderRadiusCss}" : null;
$topRightRadiusStyle = ($roundTopCorners && $borderRadiusCss) ? "border-top-right-radius: {$borderRadiusCss}" : null;
$bottomLeftRadiusStyle = $borderRadiusCss ? "border-bottom-left-radius: {$borderRadiusCss}" : null;
$bottomRightRadiusStyle = $borderRadiusCss ? "border-bottom-right-radius: {$borderRadiusCss}" : null;

@endphp

{!! Assets::inline(base_path('/vendor/streams/ui/resources/js/components/table.js')) !!}

<div
    x-data="table('{{ $tableName }}', @js($selectedStatePath))"
    class="relative"
    {{-- @if (! $isLoaded)
        wire:init="loadTable"
    @endif --}}
    {{-- @if (FilamentView::hasSpaMode())
        ax-load="visible"
    @else
        ax-load
    @endif --}}
    {{-- ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('table', 'filament/tables') }}" --}}>

    @if ($paginator->count() > 0 || $hasActiveFilters)
    <x-ui::table.container :border-radius-class="$borderRadiusClass">

        @if ($heading || $description || $headerActions)
        <x-ui::table.header :heading="$heading" :description="$description" :actions="$headerActions" />
        @endif

        @if ($bulkActions || $filters || $views)
        <div class="flex flex-col gap-x-3 p-3">

            <div class="flex items-center gap-3">

                <x-ui::table.views :views="$views" :tableName="$tableName" :active="$this->getActiveTableView($tableName)" />

                <div class="flex items-center gap-2">
                    @if ($filters)
                    <div x-data="{open: false}" x-on:click.outside="open=false" x-on:keydown.escape.window="open=false" class="flex justify-center relative z-20">

                        <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-500">
                            <x-heroicon-c-funnel class="h-5 w-5" />
                        </button>
                    
                        <x-ui::table.filters
                            {{-- :form="$getFiltersForm()" --}}
                            :filters="$filters"
                            :tableName="$tableName"
                            x-cloak
                            x-show="open"
                            class="absolute top-full left-0 w-72 bg-white p-4 border rounded-lg shadow-md"/>
                    </div>
                    @endif

                    <x-ui::table.search :table="$table" :tableName="$tableName" />
                </div>

            </div>
            
        </div>
        <div>
            <x-ui::table.indicators :table="$table"/>
        </div>
        @endif

        <table class="min-w-full border-separate border-spacing-0 divide-y divide-gray-200">

            <x-ui::table.head
                :table="$table"
                :tableName="$tableName"
                :columns="$columns"
                :actions="$actions"
                :bulkActions="$bulkActions"
                :top-left-radius-style="$topLeftRadiusStyle"
                :top-right-radius-style="$topRightRadiusStyle"
            />

            <tbody class="divide-y divide-gray-200">

                @foreach ($paginator as $entry)
                @php
                    $entryUrl = $getEntryUrl($entry);
                    $isLastBodyRow = ! $isPaginated && $loop->last;
                @endphp
                <x-ui::table.row
                    :table="$table"
                    :tableName="$tableName"
                    :entry="$entry"
                    :columns="$columns"
                    :actions="$actions"
                    :bulkActions="$bulkActions"
                    :entryUrl="$entryUrl"
                    :is-last="$isLastBodyRow"
                    :bottom-left-radius-style="$bottomLeftRadiusStyle"
                    :bottom-right-radius-style="$bottomRightRadiusStyle"
                />
                @endforeach

            </tbody>

            @if ($isPaginated)
            <x-ui::table.foot
                :table="$table"
                :tableName="$tableName"
                :paginator="$paginator"
                :paginationOptions="$paginationOptions"
                :bottom-left-radius-style="$bottomLeftRadiusStyle"
                :bottom-right-radius-style="$bottomRightRadiusStyle"
            />
            @endif

        </table>

    </x-ui::table.container>

    <x-ui::table.bulk-toolbar :bulk-actions="$bulkActions" />

    @elseif ($emptyState = $getEmptyState())
    {{ $emptyState }}
    @else
    <div>
        <x-ui::empty-state
            :actions="$getEmptyStateActions()"
            :description="$getEmptyStateDescription()"
            :components="$getEmptyStateComponents()"
            :heading="$getEmptyStateHeading()"
            :icon="$getEmptyStateIcon()"
        />
    </div>
    @endif

</div>
