<div class="flex-shrink-0 flex mt-5 px-2 space-y-1">
    <div class="text-black dark:text-white opacity-25 text-xs">
        {{ number_format(microtime(true) - Request::server('REQUEST_TIME_FLOAT'), 2) . ' s' }}&nbsp;|&nbsp;
        @php
        $size = memory_get_usage(true);

        $unit = ['b', 'kb', 'mb', 'gb', 'tb', 'pb'];

        echo round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
        @endphp
    </div>
</div>
