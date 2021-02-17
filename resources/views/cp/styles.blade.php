<!-- styles.blade.php -->
{{ Assets::load('styles', 'ui::css/variables.css') }}
{{ Assets::load('styles', 'ui::css/tailwind.css') }}
{{ Assets::load('styles', 'ui::css/theme.css') }}

{!! Assets::collection('styles')->tags() !!}

@if ($theme)
<style>
    :root {
        --cp-spacing: {{ $theme->spacing }};
        --cp-radius: {{ $theme->radius }};

        --cp-color-light: {{ $theme->light }};
        --cp-color-dark: {{ $theme->dark }};
        --cp-color-primary: {{ $theme->primary }};
        --cp-color-secondary: {{ $theme->secondary }};
    }
</style>
@endif
