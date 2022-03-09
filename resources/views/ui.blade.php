@php
    $theme = Streams::repository('cp.themes')
        ->find(Config::get('streams.ui.cp_theme', 'default'));

    View::share('theme', $theme);
@endphp

@include('ui::cp.styles')

{!! $content !!}

@include('ui::cp.assets')
