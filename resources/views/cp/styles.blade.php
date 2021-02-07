<!-- CSS -->
{{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet"> --}}

{{--<link href="/vendor/streams/ui/js/index.css" rel="stylesheet">--}}
{{--<link href="/vendor/streams/ui/css/variables.css" rel="stylesheet">--}}

<style>
    :root {
        --density: {{ $theme->density ?: 2 }};
        --radius: {{ $theme->radius ?: 0.5 }};
        --light: {{ $theme->light ?: "#ffffff" }};
        --dark: {{ $theme->dark ?: "#000000" }};
        --primary: {{ $theme->primary ?: "#4e42d9" }};
        --topbar-bg-color: {{ $theme->topbar_bg_color ?: "#cccccc" }};
        --topbar-text-color: {{ $theme->topbar_text_color ?: "#000000" }};
        --sidebar-bg-color: {{ $theme->sidebar_bg_color ?: "#cccccc" }};
        --sidebar-text-color: {{ $theme->sidebar_text_color ?: "#000000" }};
        --input-bg-color: {{ $theme->input_bg_color ?: "#ffffff" }};
        --input-text-color: {{ $theme->input_text_color ?: "#000000" }};
    }
</style>

<!-- Assets::tags() -->
{!! Assets::collection('styles')->tags() !!}

{{-- <link href="/vendor/streams/ui/css/theme.css" rel="stylesheet"> --}}
