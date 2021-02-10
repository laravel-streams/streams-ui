<!-- CSS -->
{{ Assets::load('styles', 'ui::css/tailwind.css') }}
{{ Assets::load('styles', 'ui::css/theme.css') }}

<style>
    :root {
        --cp-spacing: {{ $theme->density ?: 2 }};
        --cp-radius: {{ $theme->radius ?: 0.5 }};

        --cp-color-light: {{ $theme->light ?: "#ffffff" }};
        --cp-color-dark: {{ $theme->dark ?: "#000000" }};
        --cp-color-primary: {{ $theme->primary ?: "#4e42d9" }};
    }
</style>

<!-- Assets::tags() -->
<!-- @todo do we namespace these like cp.styles? -->
{!! Assets::collection('styles')->tags() !!}
