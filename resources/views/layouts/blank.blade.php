<!DOCTYPE html>
<html lang="en">

<head>
    @include('ui::layouts.partials.head')
</head>

<body class="flex w-full h-screen overflow-hidden">

    <main class="w-full overflow-y-auto">

        @yield('content', $content ?? null)

        @ui('alerts', [
            'alerts' => Messages::get(),
        ])
        
    </main>

    @include('ui::layouts.partials.assets')

</body>

</html>
