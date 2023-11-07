<!DOCTYPE html>
<html lang="en">

<head>
    @include('ui::layouts.partials.head')
</head>

<body class="flex w-full h-screen overflow-hidden bg-gray-50">

    <aside class="w-72">

        <header class="fi-sidebar-header flex h-16 items-center bg-white px-6 ring-1 ring-gray-950/5 lg:shadow-sm">
            <a href="{{ URL::to('admin') }}">
                {{ __(config('app.name')) }}
            </a>
        </header>

        {{-- Navigation --}}
        <nav class="px-4 py-4">
            <ul class="flex flex-col gap-y-1">
                @foreach(\Streams\Ui\Support\Facades\UI::currentPanel()->getNavigationItems() as $item)
                <li>
                    <a href="{{ url($item->url) }}" class="relative flex items-center justify-start gap-x-3 rounded-lg px-2 py-2  outline-none transition duration-75 hover:bg-gray-100 focus-visible:bg-gray-100 {{ url($item->url) == Request::url() ? 'bg-gray-100 text-indigo-600' : null }}">
                        {{ __($item->text) }}
                    </a>
                </li>
                @endforeach
            </ul>
        </nav>
        {{-- EOF Navigation --}}

        <div class="px-6 mt-2">
            <div class="opacity-50 text-xs">
                {{ response_time() . ' s' }}&nbsp;|&nbsp;{{ memory_usage() }}
            </div>
        </div>

    </aside>

    <main class="w-full overflow-y-auto">

        {{-- Topbar --}}
        <div class="flex h-16 items-center gap-x-4 bg-white px-4 shadow-sm ring-1 ring-gray-950/5 md:px-6 lg:px-8">
            &nbsp;
        </div>
        {{-- EOF Topbar --}}

        {!! $slot !!}

    </main>

    @include('ui::layouts.partials.assets')

</body>

</html>
