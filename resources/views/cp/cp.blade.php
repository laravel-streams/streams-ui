<!doctype html>
<html lang="en">

<head>
    @include('ui::cp.head')
</head>

<body>

    <div class="grid grid-cols-12 min-h-screen">

        @include('ui::cp.sidebar')

        <main class="col-span-10">

            @include('ui::cp.top')
            @include('ui::cp.content')

        </main>

    </div>

    @include('ui::cp.assets')
    @include('ui::cp.messages')

</body>

</html>
