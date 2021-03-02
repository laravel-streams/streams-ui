@php
    $theme = Streams::entries('cp.themes')
        ->find(Config::get('streams.ui.cp.theme', 'default'));

    View::share('theme', $theme);
@endphp

@include('ui::cp.styles')

{!! $content !!}

@include('ui::cp.assets')
