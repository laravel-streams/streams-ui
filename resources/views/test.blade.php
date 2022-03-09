<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
    <base href="/">
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">

    <script defer src="{{ asset('vendor/streams/ui/js/ui.js') }}"></script>
    <link href="{{ asset('vendor/streams/ui/css/variables.css') }}" rel="stylesheet" data-element-import>
    <link href="{{ asset('vendor/streams/ui/css/tailwind.css') }}" rel="stylesheet" data-element-import>
    <link href="{{ asset('vendor/streams/ui/css/theme.css') }}" rel="stylesheet" data-element-import>
</head>
<body>
<div>
    <x-ui::cp brand-mode="ffa">
        <x-slot name="sidebar">
            @area('sidebar')
        </x-slot>
        <x-slot name="topbar">
            @stack('topbar')
        </x-slot>
        @yield('content')
    </x-ui::cp>
</div>

<script>
window.addEventListener('DOMContentLoaded', function () {
    var streams = window.streams;
    streams.ui.app.initialize({
        providers: [
            streams.ui.CoreServiceProvider,
            streams.ui.UiServiceProvider,
        ],
        config   : {
            ui: {}
        }
    }).then(function (app) {
        return app.boot();
    }).then(function (app) {
        return app.start();
    });
});
</script>
</body>
</html>
