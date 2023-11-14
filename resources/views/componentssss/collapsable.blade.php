<div x-data="{open: false}" class="overflow-hidden rounded-lg bg-white shadow px-6 py-4 min-w-[15rem]">

    <div @click="open=!open" class="text-xl font-medium cursor-pointer">
        {{ $text }}
    </div>

    <div x-show="open" class="mt-4">
        This is the collapsable content.
    </div>

</div>
