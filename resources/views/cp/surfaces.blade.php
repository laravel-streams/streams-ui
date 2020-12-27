<div x-data="streams.core.app.get('surfaces')()">
    <div class="absolute top-0 left-0 h-screen w-screen bg-white dark:bg-black z-40 border-8 border-black dark:border-white overflow-scroll" x-show="isOpen()">
        <div x-html="content">...</div>
        <div class="text-2xl text-black dark:text-white cursor-pointer fixed top-0 right-0" @click="isOpen() ? close() : show();"
        x-on:show-surfaces.window="open(); load($event.detail.url)"
        x-on:close-surfaces.window="close()"
        >Close</div>
    </div>
</div>
