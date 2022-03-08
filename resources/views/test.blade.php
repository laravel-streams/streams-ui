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
    <link href="{{ asset('vendor/streams/ui/css/variables.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/streams/ui/css/tailwind.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/streams/ui/css/theme.css') }}" rel="stylesheet">
</head>
<body>
<div>
    <x-ui::control-panel brand-mode="ff">
        <x-slot name="sidebar">
            <div class="c-sidebar"> {{-- shold be a component --}}
                sidebar
                <my-element>sdf</my-element>
            </div>
        </x-slot>
        <x-ui::alert type="success">
            Hello
        </x-ui::alert>
    </x-ui::control-panel>
</div>

<script>
window.addEventListener('DOMContentLoaded', function(){
    var streams = window.streams;
    streams.ui.app.initialize({
        providers: [
            streams.ui.CoreServiceProvider,
            streams.ui.UiServiceProvider,
        ]
    }).then(function (app){
        return app.boot()
    }).then(function (app){
        return app.start()
    });
})
</script>
</body>
</html>
