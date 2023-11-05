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
                @foreach(app('ui')->getCurrentPanel()->getNavigationGroups() as $group)
                <li>
                    {!! $group->render() !!}
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

            {{-- @ui('button', [
                'tag' => 'a',
                'text' => 'Create',
                'url' => '/{request.segments.0}/{request.segments.1}/create',
            ]) --}}

            {{-- @ui('admin.menu', [
                'attributes' => [
                    'class' => 'flex items-center justify-end flex-grow',
                ],
                'wrapper_attributes' => [
                    'class' => 'flex-grow',
                ],
                'items' => [
                        [
                            'component' => 'dropdown',
                            'toggle' => [
                                [
                                    'component' => 'avatar',
                                    'src' => 'ryan@pyrocms.com',
                                    'alt' => 'Ryan Thompson',
                                    'attributes' => [
                                        'class' => ['rounded-full h-10 w-10'],
                                    ],
                                ],
                            ],
                            'components' => [
                                [
                                    'component' => 'anchor',
                                    'text' => 'Logout',
                                    'url' => '/admin/logout'
                                ],
                                [
                                    'component' => 'anchor',
                                    'text' => 'View Frontend',
                                    'url' => '/',
                                ],
                            ]
                        ],
                ],
            ]) --}}

            <div>

                <div x-data="{open: false}" class="relative" @click.outside="open=false">
                    <button @click="open=!open">
                        
                    </button>
                    <div x-show="open" class="absolute">
                        <a href="{{ URL::to('admin/logout') }}">Logout</a>
                    </div>
                </div>

            </div>
        </div>

        {!! $slot !!}

        {{-- @ui('alerts', [
            'alerts' => Messages::get(),
        ]) --}}
        
    </main>

    @include('ui::layouts.partials.assets')

</body>

</html>
