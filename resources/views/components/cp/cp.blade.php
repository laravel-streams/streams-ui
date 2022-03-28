<!doctype html>
<html lang="en">

@php
    $theme = Streams::repository('cp.themes')
        ->find(Config::get('streams.ui.cp_theme', 'default'));

    $theme = $theme ?: Streams::entries('cp.themes')->first();
    
    View::share('theme', $theme);
@endphp

<head>
    @include('ui::components.cp.head')
</head>

<body>
    
    <div class="o-cp {{ isset($theme) ? $theme->brand_mode : null }}">

        @include('ui::components.cp.sidebar')

        <div class="o-cp__main">
            @include('ui::components.cp.top')
            @include('ui::components.cp.content')
            {{-- @include('ui::components.cp.footer') --}}
        </div>

    </div>

    @include('ui::components.cp.assets')
    @include('ui::components.cp.messages')

    @include('ui::components.cp.surfaces')
    @include('ui::components.cp.modal')

</body>

</html>
