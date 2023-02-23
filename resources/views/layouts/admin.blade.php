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

        @livewire('admin.navigation', [
            'attributes' => [
                'class' => 'my-6',
            ],
        ])

        <div class="my-2">
            <div class="opacity-50 text-xs">
                {{ response_time() . ' s' }}&nbsp;|&nbsp;{{ memory_usage() }}
            </div>
        </div>

    </aside>

    <main class="w-full overflow-y-auto">

        {{-- Topbar --}}
        <div class="bg-gray-200 w-full p-4 flex justify-between items-center">

            @livewire('anchor', [
                'text' => 'Create',
                'url' => '/{request.segments.0}/{request.segments.1}/create',
                'attributes' => [
                    'class' => ['rounded bg-black text-white px-3 py-2'],
                ],
            ])

            @livewire('admin.menu', [
                'attributes' => [
                    'class' => 'flex items-center justify-end',
                ],
                'wrapper_attributes' => [
                    'class' => 'flex-grow',
                ],
                'items' => [
                        [
                            'component' => 'avatar',
                            'src' => 'https://gravatar.com/avatar/cd7e95aa74ded76c1d92374b20e5c34c?s=128',
                            'alt' => 'Ryan Thompson',
                            'attributes' => [
                                'class' => ['rounded-full h-10 w-10'],
                            ],
                        ],
                        [
                            'component' => 'anchor',
                            'text' => 'Logout',
                            'url' => '/admin/logout'
                        ],
                ],
            ])

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

        {{-- Content --}}
        @livewire('breadcrumbs')

        {!! $slot !!}
    </main>

    @include('ui::layouts.partials.assets')

</body>

</html>
