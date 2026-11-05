<x-ui::page
    @class([
        'edit-entry-page',
        // 'edit-entry-' . str_replace('/', '-', $this->getResource()::getSlug()),
    ])
>
    <div class="flex flex-col gap-y-6">
        
        {{ $this->getForm() }}

    </div>
</x-ui::page>
