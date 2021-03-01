<!-- cp.blade.php -->
<!doctype html>
<html lang="en">

@php
    $theme = Streams::entries('cp.themes')
        ->find(Config::get('streams.ui.cp.theme', 'default'));

    View::share('theme', $theme);
@endphp

<head>
    @include('ui::cp.head')
</head>

<body>
    
    <div class="o-cp {{ $theme->brand_mode }}">

        @include('ui::cp.sidebar')

        <div class="o-cp__main">
            @include('ui::cp.top')
            @include('ui::cp.content')
            {{-- @include('ui::cp.footer') --}}
        </div>

    </div>

    @include('ui::cp.assets')
    @include('ui::cp.messages')

    @include('ui::cp.surfaces')
    {{-- @include('ui::cp.modal') --}}

</body>

</html>
