<div aria-live="assertive" class="z-50 pointer-events-none fixed inset-0 flex items-start px-4 py-6 sm:items-start sm:p-6">
    <div class="flex w-full flex-col items-center space-y-4 sm:items-center">
        
        {{-- Simple --}}
        @foreach (\Streams\Ui\Support\Facades\Notifications::all() as $notification)
        @php
        $id = 'message-' . now() . '-' . $loop->index;
        @endphp
        <div x-data="{
            show: true,
            timeout: {{ $notification->getDuration() ?? 0 }},
            countdown: 0,
            width: 100,
            intervalHandle: null,
        }" x-show="show" id="{{ $id }}" x-init="() => {
                if (timeout > 0) {
                    countdown = timeout;
                    width = 100;
                    intervalHandle = setInterval(() => {
                        countdown -= 0.1;
                        width = (countdown / timeout) * 100;
        
                        if (countdown <= 0) {
                            clearInterval(intervalHandle);
                            show = false;
                        }
                    }, 100);

                    setTimeout(() => { show = false }, timeout * 1000);
                } else {
                    countdown = 0;
                    width = 0;
                }
            }"
            x-on:keydown.escape.window="show=false"
            class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 relative">

            <div class="p-4">
                <div class="flex items-start">

                    @if ($icon = $notification->getIcon())
                    <x-ui::icon :icon="$icon" class="w-7 h-7" />
                    @endif

                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="font-medium text-gray-900">{!! $notification->getTitle() !!}</p>
                        @if ($notification->getDescription())
                        <p class="mt-1 text-gray-500">{{ $notification->getDescription() }}</p>
                        @endif
                    </div>

                    <div class="ml-4 flex flex-shrink-0">
                        <button type="button" @click="show=false"
                            class="inline-flex rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="sr-only">Close</span>
                            <x-heroicon-o-x-mark class="h-7 w-7" />
                        </button>
                    </div>

                </div>
            </div>

            <div x-show="timeout" class="absolute inset-bottom mb-6 h-px -mt-px w-full">
                <div class="h-3 bg-black transition-all ease-linear" :style="`width: ${width}%;`"></div>
            </div>
        </div>
        @endforeach

        {{-- Split Buttons --}}
        {{-- <div x-data="{ show: true }" x-show="show"
            class="pointer-events-auto flex w-full max-w-md divide-x divide-gray-200 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
            <div class="flex w-0 flex-1 items-center p-4">
                <div class="w-full">
                    <p class="font-medium text-gray-900">Receive notifications</p>
                    <p class="mt-1 text-gray-500">Notifications may include alerts, sounds, and badges.</p>
                </div>
            </div>
            <div class="flex">
                <div class="flex flex-col divide-y divide-gray-200">
                    <div class="flex h-0 flex-1">
                        <button type="button"
                            class="flex w-full items-center justify-center rounded-none rounded-tr-lg border border-transparent px-4 py-3 font-medium text-indigo-600 hover:text-indigo-500 focus:z-10 focus:outline-none focus:ring-2 focus:ring-indigo-500">Reply</button>
                    </div>
                    <div class="flex h-0 flex-1">
                        <button type="button" @click="show=false"
                            class="flex w-full items-center justify-center rounded-none rounded-br-lg border border-transparent px-4 py-3 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">Don't
                            allow</button>
                    </div>
                </div>
            </div>
        </div> --}}
        {{-- EOF Split Buttons --}}

    </div>
</div>
