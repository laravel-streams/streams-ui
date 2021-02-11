<!-- styles.blade.php -->
{{ Assets::load('styles', 'ui::css/variables.css') }}
{{ Assets::load('styles', 'ui::css/tailwind.css') }}
{{ Assets::load('styles', 'ui::css/theme.css') }}

<!-- Assets::tags() -->
<!-- @todo do we namespace these like cp.styles? -->
{!! Assets::collection('styles')->tags() !!}

<style>
    :root {
        --cp-spacing: {{ $theme->density ?: 2 }};
        --cp-radius: {{ $theme->radius ?: 0.5 }};

        --cp-color-light: {{ $theme->light ?: "#ffffff" }};
        --cp-color-dark: {{ $theme->dark ?: "#000000" }};
        --cp-color-primary: {{ $theme->primary ?: "#4e42d9" }};
        --cp-color-secondary: {{ $theme->secondary ?: "#cccccc" }};
    }
</style>
