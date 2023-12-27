@props([
    'breadcrumbs' => [],
    'description' => null,
    'heading' => null,
    'actions' => [],
])
<div>
    
    <x-ui::header
        :heading="$heading"
        headingSize="xl"
        :breadcrumbs="$breadcrumbs"
        :subheading="$description"
        :actions="$actions"
    />

</div>
