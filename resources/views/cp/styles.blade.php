<!-- styles.blade.php -->
{{ Assets::load('styles', 'ui::css/variables.css') }}
{{ Assets::load('styles', 'ui::css/tailwind.css') }}
{{ Assets::load('styles', 'ui::css/theme.css') }}

{!! Assets::collection('styles')->tags() !!}

@if ($theme)
<style>
    :root {
        --ls-spacing: {{ $theme->spacing }};
        --ls-radius: {{ $theme->radius }};

        --ls-color-light: {{ $theme->light }};
        --ls-color-dark: {{ $theme->dark }};
        --ls-color-primary: {{ $theme->primary }};
        --ls-color-secondary: {{ $theme->secondary }};
    }
</style>
@endif
