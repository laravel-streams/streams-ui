<!doctype html>
<html lang="en">

<head>
    @include('ui::cp.head')
</head>

<body>
    <!-- cp.blade.php -->
    <div class="grid grid-cols-16 min-h-screen">
        <aside class="col-span-16 md:col-span-5 lg:col-span-4 xl:col-span-3 xxxl:col-span-2">
            @include('ui::cp.sidebar')
        </aside>
        <main class="col-span-16 md:col-span-11 lg:col-span-12 xl:col-span-13 xxxl:col-span-14 bg-gray-100">

            @include('ui::cp.top')
            @include('ui::cp.content')

        </main>

    </div>

    @include('ui::cp.assets')
    @include('ui::cp.messages')

</body>

</html>
