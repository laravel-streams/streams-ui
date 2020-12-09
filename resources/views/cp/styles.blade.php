<!-- CSS -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">

<link href="/vendor/streams/ui/css/variables.css" rel="stylesheet">

{{-- @todo Inject Other variables here. --}}
@if ($theme = Streams::entries('theme')->find('settings'))
<style>
    :root {
        --color-black: {{ $theme->primary }}
    }
</style>
@endif

<link href="/vendor/streams/ui/css/theme.css" rel="stylesheet">
