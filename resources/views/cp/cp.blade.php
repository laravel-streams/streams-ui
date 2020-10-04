<!doctype html>
<html lang="en">

<head>
    @include('ui::cp/partials/head')
</head>

<body>

    <div class="h-screen flex overflow-hidden bg-gray-100">

        @include('ui::cp/partials/sidebar')

        <div class="flex flex-col w-0 flex-1 overflow-hidden">

            @include('ui::cp/partials/top')
            @include('ui::cp/partials/content')

        </div>

    </div>

    @include('ui::cp/partials/assets')

</body>

</html>
