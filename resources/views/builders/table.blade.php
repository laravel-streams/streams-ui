@php
$actions = $table->getActions();
$columns = $table->getColumns();
$entries = $getEntries();

$paginationOptions = $table->getPaginationOptions();

$heading = $table->getHeading();
$description = $table->getDescription();
@endphp

<x-ui::table.container>

    @if ($heading || $description)
    <x-ui::table.header :heading="$heading" :description="$description" />
    @endif

    <table class="min-w-full divide-y divide-gray-200">

        <x-ui::table.head :table="$table" :columns="$columns" :actions="$actions" />

        <tbody class="divide-y divide-gray-200 bg-white">

            @foreach ($entries as $entry)
            <x-ui::table.row :table="$table" :entry="$entry" :columns="$columns" :actions="$actions" />
            @endforeach

        </tbody>

        <x-ui::table.foot :table="$table" :paginator="$entries" :paginationOptions="$paginationOptions" />

    </table>

</x-ui::table.container>
