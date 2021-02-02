<!-- cp.blade.php -->
<!doctype html>
<html lang="en">

<head>
    @include('ui::cp.head')
</head>

<body class="ls-cp --topbar-brand --topbar-fixed">
    
    <div class="ls-cp__layout">

        @include('ui::cp.sidebar')

        <main>
            @include('ui::cp.top')
            @include('ui::cp.content')
        </main>

    </div>

    @include('ui::cp.assets')
    @include('ui::cp.messages')

    @include('ui::cp.surfaces')
    @include('ui::cp.modal')

</body>

</html>
