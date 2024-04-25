<!DOCTYPE html>
<html lang="en" class="h-full overflow-x-hidden">

<head>
    @include('ui::layouts.partials.head')
</head>

<body class="h-screen">

    {!! $slot !!}

    @include('ui::layouts.partials.assets')

    @livewireScriptConfig

    <x-ui::messages/>

</body>

</html>
