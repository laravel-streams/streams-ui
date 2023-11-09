<div x-data="{open: false}" class="relative">

    <div x-on:click="open=!open">
        <livewire:button :text="'Toggle'" />
    </div>

    {{--
        Dropdown menu, show/hide based on menu state.

        Entering: "transition ease-out duration-100"
        From: "transform opacity-0 scale-95"
        To: "transform opacity-100 scale-100"
        Leaving: "transition ease-in duration-75"
        From: "transform opacity-100 scale-100"
        To: "transform opacity-0 scale-95"
    --}}
    <div x-show="open" x-cloak class="absolute left-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
        <div class="py-1" role="none">
            {{-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" --}}
            {{-- <a href="#" class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">Account settings</a> --}}
            @foreach ($content as $component => $text)
            <div class="text-gray-700 block px-4 py-2 text-sm" role="menuitem" tabindex="-1" id="menu-item-0">
                <livewire:anchor :text="$text" :url="'/admin'" />
            </div>
            @endforeach
        </div>
    </div>

</div>
