<div class="flex w-full h-screen overflow-hidden">

    <aside class="bg-gray w-72 px-4">
        
        <div class="my-4">
            <a href="{{ URL::to('admin') }}">
                {{ __(config('app.name')) }}
            </a>
        </div>

        <div class="my-2">
            <nav>
                <ul>
                    @foreach($component->navigation as $section)
                    <li><a href="{{ $section['url'] }}">{{ $section['text'] }}</a></li>
                    @endforeach
                </ul>
            </nav>
        </div>

        <div class="my-2">
            <div class="opacity-50 text-xs">
                {{ number_format(microtime(true) - Request::server('REQUEST_TIME_FLOAT'), 2) . ' s' }}&nbsp;|&nbsp;
                @php
                $size = memory_get_usage(true);
                $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];
                echo round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
                @endphp
            </div>
        </div>
        
    </aside>

    <main class="w-full">
        
        <div class="bg-gray w-full p-4 flex justify-between">
            <div class="flex">
                
                <a class="bg-black text-white px-3 py-2" href="./create">New Thing</a>
                
            </div>
            <div class="flex justify-end">
                
                <div x-data="{open: false}" class="relative" @click.outside="open=false">
                    <button @click="open=!open">
                        <img src="https://gravatar.com/avatar/cd7e95aa74ded76c1d92374b20e5c34c?s=128" alt="Ryan Thompson" class="rounded-full h-10 w-10">
                    </button>
                    <div x-show="open" class="absolute">
                        <a href="{{ URL::to('admin/logout') }}">Logout</a>
                    </div>
                </div>
                
            </div>
        </div>

        {{-- @include('ui::components.cp.content') --}}
    </main>

</div>
