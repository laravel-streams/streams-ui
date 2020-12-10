<div x-data="surfaces()">
    <div class="absolute top-0 left-0 h-screen w-screen bg-white dark:bg-black z-40 border-8 border-black dark:border-white flex items-center justify-center" x-show="isOpen()">
        <div class="text-2xl text-black dark:text-white cursor-pointer" @click="isOpen() ? close() : show();"
        x-on:show-surfaces.window="open()"
        x-on:close-surfaces.window="close()"
        >Close</div>
    </div>
</div>

<script>
    function surfaces() {
        return {
            show: false,
            open() { this.show = true },
            close() { this.show = false },
            isOpen() { return this.show === true },
        }
    }
</script>
