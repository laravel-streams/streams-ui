<!-- CSS -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">

{{-- <link href="/vendor/streams/ui/js/index.css" rel="stylesheet"> --}}
<link href="/vendor/streams/ui/css/theme.css" rel="stylesheet">
<link href="/vendor/streams/ui/css/variables.css" rel="stylesheet">

@php
    $theme = Streams::entries('cp.theme')->first();
@endphp

<style>
    :root {
        --density: {{ $theme->density ?: 2 }};
        --radius: {{ $theme->density ?: 0.5 }};
        --topbar-bg-color: {{ $theme->topbar_bg_color ?: "#cccccc" }};
        --topbar-text-color: {{ $theme->topbar_text_color ?: "#000000" }};
        --sidebar-bg-color: {{ $theme->sidebar_bg_color ?: "#cccccc" }};
        --sidebar-text-color: {{ $theme->sidebar_text_color ?: "#000000" }};
    }
</style>

<!-- Assets::tags() -->
{!! Assets::collection('styles')->tags() !!}
