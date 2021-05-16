<!-- styles.blade.php -->
{{ Assets::load('styles', 'ui::css/variables.css') }}
{{ Assets::load('styles', 'ui::css/theme.css') }}

{{ Assets::load('styles', 'ui::css/tailwind.css') }}

{!! Assets::collection('styles')->tags() !!}

@if ($theme)
<style>
    :root {
        @php

            $styles = array_filter([
                '--ls-spacing' => $theme->spacing,
                '--ls-radius' => $theme->radius,
                
                '--ls-color-light' => $theme->light,
                '--ls-color-dark' => $theme->dark,
                
                '--ls-color-black' => $theme->black,
                '--ls-color-white' => $theme->white,
                
                '--ls-color-primary' => $theme->primary,
                '--ls-color-secondary' => $theme->secondary,
                
                '--ls-color-text' => $theme->text,
                '--ls-color-buttons' => $theme->buttons,
            ]);

        @endphp

        @foreach ($styles as $key => $value)
        {{ $key }}: {{ $value }};
        @endforeach
    }
</style>
@endif
