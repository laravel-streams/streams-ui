<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    @include('ui::layouts.partials.head')
</head>

<body class="h-screen">

    {!! $slot !!}

    @include('ui::layouts.partials.assets')

    <x-ui::messages/>

</body>

</html>
