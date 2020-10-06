<div class="_hidden md:flex md:flex-shrink-0">
    <div class="flex flex-col w-64">

        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex flex-col flex-grow bg-black pb-4 overflow-y-auto">
            <div class="mt-5 flex-1 flex flex-col">

                {{-- @section('navigation')
                <nav class="flex-1 px-2 space-y-1">
                    @foreach ($cp->navigation as $key => $item)
                    <a href="/ui/{{ $item->id }}/table"
                        class="group flex items-center px-2 py-2 text-sm leading-5 font-medium {{ $item->id == request()->segment(2) ? 'text-white' : 'text-white opacity-50' }} rounded-md focus:outline-none transition ease-in-out duration-150">
                        {{ $item->title }}
                    </a>
                    @endforeach
                </nav>
                @show --}}

                <x-streams::cp.navigation></x-streams::cp.navigation>

            </div>
        </div>

    </div>
</div>
