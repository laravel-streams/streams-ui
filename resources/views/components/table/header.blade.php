{{-- @props([
    'actions' => [],
    'actionsPosition',
    'description' => null,
    'heading' => null,
]) --}}

<div
    {{
        $attributes->class([
            'flex flex-col gap-3 p-4 sm:px-6',
            //'sm:flex-row sm:items-center' => $actionsPosition === HeaderActionsPosition::Adaptive,
        ])
    }}
>
    @if ($heading || $description)
        <div class="grid gap-y-1">
            @if ($heading)
                <h2
                    class="text-base font-semibold leading-6 text-gray-950"
                >
                    {{ $heading }}
                </h2>
            @endif

            @if ($description)
                <p
                    class="text-sm text-gray-600"
                >
                    {{ $description }}
                </p>
            @endif
        </div>
    @endif

    {{-- @if ($actions)
        <x-filament-tables::actions
            :actions="$actions"
            :alignment="Alignment::Start"
            wrap
            @class([
                'ms-auto' => $actionsPosition === HeaderActionsPosition::Adaptive && ! ($heading || $description),
                'sm:ms-auto' => $actionsPosition === HeaderActionsPosition::Adaptive,
            ])
        />
    @endif --}}
</div>
