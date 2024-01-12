<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">

<head>
    @include('ui::layouts.partials.head')
</head>

@php
    View::share('topNavigation', $topNavigation = false);
@endphp

<body class="h-full">

    @include('ui::layouts.partials.sidebar')
    
    <div class="{{ $topNavigation ? '' : 'lg:pl-72' }} h-full flex flex-col">

        @include('ui::layouts.partials.topbar')

        <main class="flex-grow">
            {!! $slot !!}
        </main>

        @include('ui::layouts.partials.footer')

    </div>

    @include('ui::layouts.partials.assets')

</body>

</html>
