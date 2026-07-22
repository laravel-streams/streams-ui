@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $borderRadius = $getBorderRadius() ?? 'md';
    $placeholder = $getPlaceholder();
    $suggestions = $getSuggestions();
    $splitKeys = $getSplitKeys();
    $datalistId = $suggestions !== [] ? $id.'-suggestions' : null;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" class="flex">
    <div
        wire:ignore.self
        x-data="{
            tags: $wire.entangle('{{ $statePath }}'),
            draft: '',
            splitKeys: @js($splitKeys),
            normalize(value) {
                return String(value ?? '').trim()
            },
            ensureArray() {
                if (! Array.isArray(this.tags)) {
                    this.tags = []
                }
            },
            addTag() {
                if ({{ $isDisabled ? 'true' : 'false' }}) {
                    return
                }

                this.ensureArray()

                const tag = this.normalize(this.draft)

                if (tag === '') {
                    return
                }

                if (this.tags.some((existing) => String(existing).toLowerCase() === tag.toLowerCase())) {
                    this.draft = ''
                    return
                }

                this.tags = [...this.tags, tag]
                this.draft = ''
            },
            removeTag(index) {
                if ({{ $isDisabled ? 'true' : 'false' }}) {
                    return
                }

                this.ensureArray()
                this.tags = this.tags.filter((_, i) => i !== index)
            },
            onKeydown(event) {
                if (event.key === 'Enter' || this.splitKeys.includes(event.key)) {
                    event.preventDefault()
                    this.addTag()
                    return
                }

                if (event.key === 'Backspace' && this.normalize(this.draft) === '' && Array.isArray(this.tags) && this.tags.length) {
                    event.preventDefault()
                    this.removeTag(this.tags.length - 1)
                }
            },
        }"
        @class([
            'flex w-full flex-wrap items-center gap-2 border border-gray-500 bg-white px-2 py-1.5',
            "rounded-{$borderRadius}",
            'opacity-70 pointer-events-none' => $isDisabled,
        ])
    >
        <template x-for="(tag, index) in (Array.isArray(tags) ? tags : [])" :key="index">
            <span
                class="inline-flex max-w-full items-center gap-1 rounded-full bg-black px-2.5 py-1 text-sm font-semibold leading-none text-white"
            >
                <span class="truncate" x-text="tag"></span>
                <button
                    type="button"
                    class="inline-flex shrink-0 items-center justify-center rounded-full p-0.5 hover:bg-white/15 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-white/60"
                    x-on:click="removeTag(index)"
                    @disabled($isDisabled)
                >
                    <span class="sr-only">Remove</span>
                    <x-ui::icon icon="heroicon-m-x-mark" class="h-3.5 w-3.5" />
                </button>
            </span>
        </template>

        <input
            type="text"
            id="{{ $id }}"
            x-model="draft"
            x-on:keydown="onKeydown($event)"
            x-on:blur="addTag()"
            @disabled($isDisabled)
            @readonly($isReadonly())
            @required($isRequired() && blank($getState()))
            @if ($datalistId)
                list="{{ $datalistId }}"
            @endif
            placeholder="{{ $placeholder }}"
            class="min-w-[8rem] flex-1 border-0 bg-transparent px-1 py-1 text-sm text-gray-950 outline-none ring-0 placeholder:text-gray-400 focus:outline-none focus:ring-0"
        />
    </div>

    @if ($datalistId)
        <datalist id="{{ $datalistId }}">
            @foreach ($suggestions as $suggestion)
                <option value="{{ $suggestion }}"></option>
            @endforeach
        </datalist>
    @endif
</x-dynamic-component>
