<footer
    class="flex items-center w-full h-8 shrink-0 gap-x-4 border-t border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 lg:px-4">
    <div class="opacity-50 text-xs">
        {{ response_time() . ' s' }}&nbsp;|&nbsp;{{ memory_usage() }}
    </div>
</footer>
