@php
$columns = $table->getColumns();
$actions = $table->getActions();

$heading = $table->getHeading();
$description = $table->getDescription();
@endphp

<x-ui::tables.container>

    @if ($heading || $description)
    <x-ui::tables.header :heading="$heading" :description="$description" />
    @endif

    <table class="min-w-full divide-y divide-gray-200">

        <x-ui::tables.head :table="$table" :columns="$columns" :actions="$actions" />

        <tbody class="divide-y divide-gray-200 bg-white">

            @foreach ($table->getQuery()->get() as $record)
            <x-ui::tables.row :table="$table" :record="$record" :columns="$columns" :actions="$actions" />
            @endforeach

        </tbody>

        <x-ui::tables.foot :table="$table" />

    </table>

</x-ui::tables.container>
