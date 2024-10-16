{{-- <x-dynamic-component :component="$getFieldWrapperView()" :field="$field"> --}}
    @php
        //$gridDirection = $getGridDirection() ?? 'column';
        $id = $getId();
        $isDisabled = $isDisabled();
        //$isInline = $isInline();
        $statePath = $getStatePath();
    @endphp

    {{-- <x-filament::grid
        :default="$getColumns('default')"
        :sm="$getColumns('sm')"
        :md="$getColumns('md')"
        :lg="$getColumns('lg')"
        :xl="$getColumns('xl')"
        :two-xl="$getColumns('2xl')"
        :is-grid="! $isInline"
        :direction="$gridDirection"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($attributes)
                ->merge($getExtraAttributes(), escape: false)
                ->class([
                    'gap-4',
                    '-mt-4' => (! $isInline) && $gridDirection === 'column',
                    'flex flex-wrap' => $isInline,
                ])
        "
    > --}}
        @foreach ($getOptions() as $value => $label)
            @php
                $shouldOptionBeDisabled = $isDisabled;// || $isOptionDisabled($value, $label);
            @endphp

            <div
                @class([
                    //'break-inside-avoid pt-4' => (! $isInline) && $gridDirection === 'column',
                ])
            >
                <label class="flex gap-x-3">
                    <input
                        @disabled($shouldOptionBeDisabled)
                        id="{{ $id }}-{{ $value }}"
                        name="{{ $id }}"
                        type="radio"
                        value="{{ $value }}"
                        wire:loading.attr="disabled"
                        {{-- {{ $applyStateBindingModifiers('wire:model') }}="{{ $statePath }}" --}}
                        {{
                            (new \Illuminate\View\ComponentAttributeBag)
                                ->class([
                                    'mt-1 border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400 dark:bg-white/5 dark:disabled:bg-transparent dark:disabled:checked:bg-gray-600',
                                    'text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50' => ! $errors->has($statePath),
                                    'text-danger-600 ring-danger-600 focus:ring-danger-600 checked:focus:ring-danger-500/50' => $errors->has($statePath),
                                ])
                        }}
                    />

                    <div class="grid leading-6">
                        <span
                            class="font-medium text-gray-950"
                        >
                            {{ $label }}
                        </span>

                        {{-- @if ($hasDescription($value))
                            <p class="text-gray-500 dark:text-gray-400">
                                {{ $getDescription($value) }}
                            </p>
                        @endif --}}
                    </div>
                </label>
            </div>
        @endforeach
    {{-- </x-filament::grid> --}}

{{-- </x-dynamic-component> --}}
