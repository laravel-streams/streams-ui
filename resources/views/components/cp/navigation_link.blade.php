<a href="{{ $href }}"
    class="group flex items-center px-2 py-2 text-sm leading-5 font-medium {{ $link->id == request()->segment(2) ? 'text-white' : 'text-white opacity-50' }} rounded-md focus:outline-none transition ease-in-out duration-150">
    {{ $link->title }}
</a>
