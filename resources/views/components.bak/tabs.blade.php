<div>
    <div class="sm:hidden">
        
        <label for="tabs" class="sr-only">Select a tab</label>
        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
        <select id="tabs" name="tabs" class="rounded-md border py-2 pl-3 pr-10">
            @foreach ($this->tabs as $tab)
                <option>{{ $tab['text'] ?? null }}</option>
            @endforeach
        </select>
    </div>

    <div class="hidden sm:block">
        <div>
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                @foreach ($this->tabs as $tab)
                <a href="#" onclick="this.classList.toggle('border-red-500'); document.getElementById('{{ $this->id }}-{{ $loop->index }}').classList.toggle('hidden')" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    {{ $tab['text'] ?? null }}
                </a>
                @endforeach
            </nav>
        </div>
    </div>

    <div>
        @foreach ($this->tabs as $tab)
        @if (isset($tab['content']))
            <div id="{{ $this->id }}-{{ $loop->index }}" class="hidden">
            @foreach ($tab['content'] as $content)
            @livewire(Arr::pull($content, 'component'), $content)
            @endforeach
            </div>
        @endif
        @endforeach
    </div>

</div>
