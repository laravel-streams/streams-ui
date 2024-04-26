<!DOCTYPE html>
<html lang="en" class="h-full overflow-x-hidden">

<head>
    @include('ui::layouts.partials.head')
</head>

<body class="h-screen" x-cloak x-data="{}">

    {!! $slot !!}

    @include('ui::layouts.partials.assets')

    <x-ui::messages/>

</body>

</html>
