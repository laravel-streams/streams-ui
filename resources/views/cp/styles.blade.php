<!-- CSS -->
{{ Assets::load('styles', 'ui::css/theme.css') }}
{{ Assets::load('styles', 'ui::css/tailwind.css') }}

<style>
    :root {
        --cp-spacing: {{ $theme->density ?: 2 }};
        --cp-radius: {{ $theme->radius ?: 0.5 }};

        --cp-color-light: {{ $theme->light ?: "#ffffff" }};
        --cp-color-dark: {{ $theme->dark ?: "#000000" }};
        --cp-color-primary: {{ $theme->primary ?: "#4e42d9" }};

        --topbar-bg-color: {{ $theme->topbar_bg_color ?: "#cccccc" }};
        --topbar-text-color: {{ $theme->topbar_text_color ?: "#000000" }};
        --sidebar-bg-color: {{ $theme->sidebar_bg_color ?: "#cccccc" }};
        --sidebar-text-color: {{ $theme->sidebar_text_color ?: "#000000" }};
        --input-bg-color: {{ $theme->input_bg_color ?: "#ffffff" }};
        --input-text-color: {{ $theme->input_text_color ?: "#000000" }};
    }
</style>

<!-- Assets::tags() -->
<!-- @todo do we namespace these like cp.styles? -->
{!! Assets::collection('styles')->tags() !!}
