<!DOCTYPE html>
<html lang="en">

<head>
    @include('ui::layouts.partials.head')
</head>

<body class="flex w-full h-screen overflow-hidden">

    <aside class="bg-gray-200 w-72 px-4 py-2">

        <div class="my-4">
            <a href="{{ URL::to('admin') }}">
                {{ __(config('app.name')) }}
            </a>
        </div>

        {{-- Navigation --}}
        <nav>
            <ul>
                @foreach(\Streams\Ui\Support\Facades\UI::currentPanel()->getNavigationItems() as $item)
                <li>
                    <a href="{{ url($item->url) }}" class="block" style="padding: .25rem 0; {{ url($item->url) == Request::url() ? 'font-weight: bold;' : null }}">
                        {{ __($item->text) }}
                    </a>
                </li>
                @endforeach
            </ul>
        </nav>
        {{-- EOF Navigation --}}

        <div class="my-2">
            <div class="opacity-50 text-xs">
                {{ response_time() . ' s' }}&nbsp;|&nbsp;{{ memory_usage() }}
            </div>
        </div>

    </aside>

    <main class="w-full overflow-y-auto">

        {{-- Topbar --}}
        <div class="bg-gray-200 w-full p-4 flex justify-between items-center">
            &nbsp;
        </div>
        {{-- EOF Topbar --}}

        {!! $slot !!}

    </main>

    @include('ui::layouts.partials.assets')

</body>

</html>
