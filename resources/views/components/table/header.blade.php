@props([
    'breadcrumbs' => [],
    'description' => null,
    'heading' => null,
    'actions' => [],
])
<div>
    
    <x-ui::header
        :heading="$heading"
        :priority="2"
        :breadcrumbs="$breadcrumbs"
        :subheading="$description"
        :actions="$actions"
    />

</div>
