<x-ui-table :table="$table">
    
    <x-slot name="filters">
        @include('ui::table/partials/filters')
    </x-slot>
    
    <x-slot name="heading">
        @include('ui::table/partials/heading')
    </x-slot>

</x-ui-table>
