<!doctype html>
<html lang="en">

<head>
    @include('ui::cp.head')
</head>

<body>
    <!-- cp.blade.php -->
    <div class="h-screen flex overflow-hidden bg-gray-100">
        
        @include('ui::cp.sidebar')

        <main class="flex flex-col w-0 flex-1 overflow-hidden">

            @include('ui::cp.top')
            @include('ui::cp.content')

        </main>

    </div>

    @include('ui::cp.assets')
    @include('ui::cp.messages')

</body>

</html>
