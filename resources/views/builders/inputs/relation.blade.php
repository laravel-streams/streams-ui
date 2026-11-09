@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $borderRadius = $getBorderRadius() ?? 'md';
    $field->register();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" class="flex">
    <div
        wire:ignore.self
        x-data="{
            value: $wire.entangle('{{ $statePath }}'),
            multiple: @js($isMultiple()),
            canCreate: @js($canCreate()),
            searchable: @js($isSearchable()),
            term: '',
            open: false,
            options: [],
            chosen: @js($selected()),
            timer: null,
            ids() {
                if (this.multiple) {
                    return Array.isArray(this.value) ? this.value : []
                }

                return this.value === null || this.value === '' || this.value === undefined ? [] : [this.value]
            },
            async search() {
                this.options = await $wire.searchRelationInputOptions('{{ $statePath }}', this.term)
            },
            debounced() {
                clearTimeout(this.timer)
                this.timer = setTimeout(() => this.search(), 250)
            },
            async show() {
                this.open = true
                await this.search()
            },
            isChosen(option) {
                return this.ids().map(String).includes(String(option.value))
            },
            pick(option) {
                if (! this.chosen.some((c) => String(c.value) === String(option.value))) {
                    this.chosen.push(option)
                }

                if (this.multiple) {
                    if (! this.isChosen(option)) this.value = [...this.ids(), option.value]
                } else {
                    this.value = option.value
                    this.open = false
                }

                this.term = ''
            },
            remove(option) {
                this.value = this.multiple ? this.ids().filter((v) => String(v) !== String(option.value)) : null
            },
            async create() {
                const text = this.term.trim()

                if (! text) return

                const option = await $wire.createRelationInputOption('{{ $statePath }}', text)

                if (option) this.pick(option)
            },
            selectedOptions() {
                const ids = this.ids().map(String)

                return this.chosen.filter((c) => ids.includes(String(c.value)))
            },
        }"
        x-on:click.outside="open = false"
        @class([
            'relative w-full border border-gray-500 bg-white px-2 py-1.5',
            "rounded-{$borderRadius}",
            'opacity-70 pointer-events-none' => $isDisabled,
        ])
    >
        <div class="flex flex-wrap items-center gap-2">
            <template x-for="option in selectedOptions()" :key="option.value">
                <span class="inline-flex items-center gap-1 rounded-full bg-black px-2.5 py-1 text-sm font-semibold leading-none text-white">
                    <span class="truncate" x-text="option.label"></span>
                    <button type="button" x-on:click="remove(option)" @disabled($isDisabled)>
                        <span class="sr-only">Remove</span>&times;
                    </button>
                </span>
            </template>

            <input
                type="text"
                id="{{ $id }}"
                x-model="term"
                x-on:focus="show()"
                x-on:input="debounced()"
                x-on:keydown.enter.prevent="canCreate && options.length === 0 ? create() : null"
                x-on:keydown.escape="open = false"
                x-bind:readonly="! searchable"
                @disabled($isDisabled)
                @readonly($isReadonly())
                placeholder="{{ $getPlaceholder() }}"
                autocomplete="off"
                class="min-w-[8rem] flex-1 border-0 bg-transparent px-1 py-1 text-sm text-gray-950 outline-none ring-0 placeholder:text-gray-400 focus:outline-none focus:ring-0"
            />
        </div>

        <ul x-show="open" x-cloak class="absolute left-0 top-full z-10 mt-1 max-h-60 w-full overflow-auto rounded border border-gray-300 bg-white text-sm shadow">
            <template x-for="option in options" :key="option.value">
                <li>
                    <button type="button" class="w-full px-3 py-2 text-left hover:bg-gray-100" x-bind:class="isChosen(option) ? 'font-semibold' : ''" x-on:click="pick(option)" x-text="option.label"></button>
                </li>
            </template>
            <li x-show="canCreate && term.trim() !== ''">
                <button type="button" class="w-full px-3 py-2 text-left text-gray-700 hover:bg-gray-100" x-on:click="create()">
                    Create &ldquo;<span x-text="term"></span>&rdquo;
                </button>
            </li>
        </ul>
    </div>
</x-dynamic-component>
