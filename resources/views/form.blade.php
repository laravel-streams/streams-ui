<form
    x-data="{ isUploadingFile: false }"
    x-on:submit="if (isUploadingFile) $event.preventDefault()"
    x-on:file-upload-started="isUploadingFile = true"
    x-on:file-upload-finished="isUploadingFile = false"
    {{ $attributes->class(['ui-form grid gap-y-6']) }}>


{{-- <x-ui::grid :default="$getColumns('default')" :sm="$getColumns('sm')" :md="$getColumns('md')"
    :lg="$getColumns('lg')" :xl="$getColumns('xl')" :two-xl="$getColumns('2xl')" class="gap-6"> --}}
    <div>
        @foreach ($getComponents(true) as $component)
        @php
        // $isHidden = $component->isHidden();
        $isHidden = false;
        @endphp

        {{-- <x-ui::grid.column
            :wire:key="$component instanceof \Filament\Forms\Components\Field ? $this->getId() . '.' . $component->getStatePath() . '.' . $component::class : null"
            :hidden="$isHidden" :default="$component->getColumnSpan('default')" :sm="$component->getColumnSpan('sm')"
            :md="$component->getColumnSpan('md')" :lg="$component->getColumnSpan('lg')"
            :xl="$component->getColumnSpan('xl')" :twoXl="$component->getColumnSpan('2xl')"
            :defaultStart="$component->getColumnStart('default')" :smStart="$component->getColumnStart('sm')"
            :mdStart="$component->getColumnStart('md')" :lgStart="$component->getColumnStart('lg')"
            :xlStart="$component->getColumnStart('xl')" :twoXlStart="$component->getColumnStart('2xl')" @class([ match
            ($maxWidth=$component->getMaxWidth()) {
            'xs' => 'max-w-xs',
            'sm' => 'max-w-sm',
            'md' => 'max-w-md',
            'lg' => 'max-w-lg',
            'xl' => 'max-w-xl',
            '2xl' => 'max-w-2xl',
            '3xl' => 'max-w-3xl',
            '4xl' => 'max-w-4xl',
            '5xl' => 'max-w-5xl',
            '6xl' => 'max-w-6xl',
            '7xl' => 'max-w-7xl',
            default => $maxWidth,
            },
            ])
            > --}}
            @if (!$isHidden)
            {{ $component }}
            @endif
            {{-- </x-ui::grid.column> --}}
        @endforeach

        @foreach ($form->getActions() as $action)
        {!! $action->render() !!}
        @endforeach
    </div>
    {{--
</x-ui::grid> --}}

</form>
