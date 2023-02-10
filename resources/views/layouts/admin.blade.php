<!DOCTYPE html>
<html lang="en">
<head>
    @include('ui::layouts.partials.head')
</head>
<body>
    
    {{ $slot }}

    @include('ui::layouts.partials.assets')
    
</body>
</html>
