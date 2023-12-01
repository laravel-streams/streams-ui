<div {{ $attributes ->merge([
    'id' => $getId(),
    ], escape: false)
    ->merge($getHtmlAttributes(), escape: false)
    }}
    >
    <x-ui::grid :default="$getColumns('default')" :sm="$getColumns('sm')" :md="$getColumns('md')"
        :lg="$getColumns('lg')" :xl="$getColumns('xl')" :two-xl="$getColumns('2xl')" class="gap-6">
        @foreach ($getComponents(true) as $formComponent)
        @php
        /**
        * Instead of only rendering the hidden components, we should
        * render the `<div>` wrappers for all fields, regardless of
            * if they are hidden or not. This is to solve Livewire DOM
            * diffing issues.
            *
            * Additionally, any `<div>` elements that wrap hidden
                * components need to have `class="hidden"`, so that they
                * don't consume grid space.
                */
                $isHidden = $formComponent->isHidden();
                @endphp

                <x-ui::grid.column
                    :wire:key="$formComponent instanceof \Filament\Forms\Components\Field ? $this->getId() . '.' . $formComponent->getStatePath() . '.' . $formComponent::class : null"
                    :hidden="$isHidden" :default="$formComponent->getColumnSpan('default')"
                    :sm="$formComponent->getColumnSpan('sm')" :md="$formComponent->getColumnSpan('md')"
                    :lg="$formComponent->getColumnSpan('lg')" :xl="$formComponent->getColumnSpan('xl')"
                    :twoXl="$formComponent->getColumnSpan('2xl')"
                    :defaultStart="$formComponent->getColumnStart('default')"
                    :smStart="$formComponent->getColumnStart('sm')" :mdStart="$formComponent->getColumnStart('md')"
                    :lgStart="$formComponent->getColumnStart('lg')" :xlStart="$formComponent->getColumnStart('xl')"
                    :twoXlStart="$formComponent->getColumnStart('2xl')"
                    @class([
                        // match ($maxWidth=$formComponent->
                        //     getMaxWidth()) {
                        //     'xs' => 'max-w-xs',
                        //     'sm' => 'max-w-sm',
                        //     'md' => 'max-w-md',
                        //     'lg' => 'max-w-lg',
                        //     'xl' => 'max-w-xl',
                        //     '2xl' => 'max-w-2xl',
                        //     '3xl' => 'max-w-3xl',
                        //     '4xl' => 'max-w-4xl',
                        //     '5xl' => 'max-w-5xl',
                        //     '6xl' => 'max-w-6xl',
                        //     '7xl' => 'max-w-7xl',
                        //     default => $maxWidth,
                        // },
                            ])
                    >
                    @if (! $isHidden)
                    {{ $formComponent }}
                    @endif
                </x-ui::grid.column>
                @endforeach
    </x-ui::grid>
</div>
