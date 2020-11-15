<!-- navigation_link.blade.php -->
<a href="{{ $navigationLink->url() }}"
    class="group flex items-center px-2 py-2 text-sm leading-5 font-medium {{ $navigationLink->active ? 'text-white' : 'text-white opacity-50' }} rounded-md focus:outline-none transition ease-in-out duration-150">
    {{ $navigationLink->title }}
</a>
