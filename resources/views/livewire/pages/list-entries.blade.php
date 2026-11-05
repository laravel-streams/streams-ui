<x-ui::page
    @class([
        'list-entries-page',
        // 'list-entries-' . str_replace('/', '-', $this->getResource()::getSlug()),
    ])>

    <div class="flex flex-col gap-y-6 p-4">
        
        {{ $this->getTable() }}

    </div>

</x-ui::page>
