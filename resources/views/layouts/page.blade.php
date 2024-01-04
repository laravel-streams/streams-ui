<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    @include('ui::layouts.partials.head')
</head>

<body>

    {!! $slot !!}

    @include('ui::layouts.partials.assets')

</body>

</html>
