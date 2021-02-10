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

{{-- <body class="ls-cp --topbar-brand --topbar-fixed"> --}}
<body class="ls-cp {{ $theme->brand_mode }}">
    
    <div class="ls-cp__layout">

        @include('ui::cp.sidebar')

        <main>
            @include('ui::cp.top')
            @include('ui::cp.content')
        </main>

    </div>

    @include('ui::cp.assets')
    @include('ui::cp.messages')

    {{-- @include('ui::cp.surfaces')
    @include('ui::cp.modal') --}}

</body>

</html>
