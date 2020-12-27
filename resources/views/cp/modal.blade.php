<div x-data="streams.core.app.get('modal')()">
    <div class="fixed top-0 left-0 h-screen w-screen z-40 inset-0 overflow-y-auto" x-show="isOpen()">

        <div class="absolute top-0 left-0 h-screen w-screen bg-black opacity-50"></div>

    <div class="flex items-center justify-center h-screen w-screen">

        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="text-2xl text-black dark:text-dark cursor-pointer"
            x-on:show-modal.window="open(); load($event.detail.url)"
            x-on:close-modal.window="close()">
                <span x-html="content">...</span>
                <span @click="isOpen() ? close() : show();"> (CLOSE)</span>
            </div>
        </div>

    </div>
    </div>
</div>
