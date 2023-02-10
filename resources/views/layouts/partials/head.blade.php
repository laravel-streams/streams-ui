<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<title>{{ $metaTitle ?? 'Admin' }} | {{ config('app.name') }}</title>

{{-- {!! favicons('public::img/favicon.png') !!} --}}
<link rel="icon" type="image/png" href="/vendor/streams/ui/img/favicon.png"/>

{!! Assets::collection('scripts.head')->tags() !!}




<!-- styles.blade.php -->
{{ Assets::load('styles', 'ui::css/variables.css') }}
{{ Assets::load('styles', 'ui::css/theme.css') }}

{{ Assets::load('styles', 'ui::css/tailwind.css') }}

{!! Assets::collection('styles')->tags() !!}

@if (isset($theme))
<style>
    :root {
        @php

            $styles = array_filter([
                '--ui-font-size' => $theme->font_size,
                '--ui-spacing' => $theme->spacing,
                '--ui-radius' => $theme->radius,
                
                '--ui-color-light' => $theme->light,
                '--ui-color-dark' => $theme->dark,
                 
                '--ui-color-black' => $theme->black,
                '--ui-color-white' => $theme->white,
                
                '--ui-color-primary' => $theme->primary,
                '--ui-color-secondary' => $theme->secondary,
                
                '--ui-color-text' => $theme->text,
                '--ui-color-buttons' => $theme->buttons,
            ]);

        @endphp

        @foreach ($styles as $key => $value)
        {{ $key }}: {{ $value }};
        @endforeach
    }
</style>
@endif
