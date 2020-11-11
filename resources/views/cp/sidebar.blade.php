<div class="md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">

        <div class="flex flex-col flex-grow bg-black pb-4 overflow-y-auto">
            
            <div class="mt-5 flex-1 flex flex-col">
                @include('ui::cp.navigation')
            </div>

            <div class="px-4 flex align-self-bottom flex-col text-white">
                {{ number_format(microtime(true) - Request::server('REQUEST_TIME_FLOAT'), 2) . ' s' }}&nbsp;|&nbsp;
                @php
                    $size = memory_get_usage(true);

                    $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

                    echo round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
                @endphp
            </div>

        </div>

    </div>
</div>
