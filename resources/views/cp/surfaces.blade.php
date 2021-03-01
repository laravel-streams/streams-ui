<div x-data="surfaces()">
    
    <div class="absolute top-0 left-0 h-screen w-screen bg-white dark:bg-black z-40 border-8 border-black dark:border-white overflow-scroll" x-show="enabled" x-cloak>
        {{-- <div x-html="content">...</div> --}}
        <div class="text-2xl text-black dark:text-white cursor-pointer fixed top-0 right-0" @click="enabled === true ? disableSurfaces() : enableSurfaces();"
        x-on:enable-surfaces.window="alert(); enableSurfaces(); load($event.detail.url)"
        x-on:disable-surfaces.window="disableSurfaces()"
        >Close</div>
    </div>

    <div class="surfaces__stack">
        Oh. Hai.
    </div>

</div>

<script>
    function surfaces() {
            return {
                
                enabled: false,

                enableSurfaces() {
                    
                    this.enabled = true;

                    return this;
                },

                disableSurfaces() {
                    
                    this.enabled = true;

                    return this;
                }
            };
        }
</script>
