@php
    // $chartColor = $getChartColor() ?? 'gray';
    $descriptionColor = 'gray';//$getDescriptionColor() ?? 'gray';
    // $descriptionIcon = $getDescriptionIcon();
    // $descriptionIconPosition = $getDescriptionIconPosition();
    $url = $getUrl();
    $tag = $url ? 'a' : 'div';
@endphp

<{!! $tag !!}
    @if ($url)
        href="{{ $url }}"
        target="{{ $getTarget() }}"
    @endif
    {{
        $getHtmlAttributeBag()
            ->class([
                'relative rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5',
            ])
    }}
>
    <div class="grid gap-y-2">
        <div class="flex items-center gap-x-2">
            {{-- @if ($icon = $getIcon())
                <x-ui::icon
                    :icon="$icon"
                    class="h-5 w-5 text-gray-400"
                />
            @endif --}}

            <span class="font-medium text-gray-500">
                {{ $getLabel() }}
            </span>
        </div>

        <div
            class="text-3xl font-semibold tracking-tight text-gray-950">
            {{ $getValue() }}
        </div>

        @if ($description = $getDescription())
            <div class="flex items-center gap-x-1">
                {{-- @if ($descriptionIcon && in_array($descriptionIconPosition, ['before']))
                    <x-ui::icon
                        :icon="$descriptionIcon"
                        :class="$descriptionIconClasses"
                        :style="$descriptionIconStyles"
                    />
                @endif --}}

                <span
                    @class([
                        match ($descriptionColor) {
                            'gray' => 'text-gray-500',
                            default => 'text-custom-600',
                        },
                    ])
                    @style([
                        // \Filament\Support\get_color_css_variables(
                        //     $descriptionColor,
                        //     shades: [400, 600],
                        // ) => $descriptionColor !== 'gray',
                    ])
                >
                    {{ $description }}
                </span>

                {{-- @if ($descriptionIcon && in_array($descriptionIconPosition, ['after']))
                    <x-ui::icon
                        :icon="$descriptionIcon"
                        :class="$descriptionIconClasses"
                        :style="$descriptionIconStyles"
                    />
                @endif --}}
            </div>
        @endif
    </div>

    {{-- @if ($chart = $getChart()) --}}
        {{-- An empty function to initialize the Alpine component with until it's loaded with `ax-load`. This removes the need for `x-ignore`, allowing the chart to be updated via Livewire polling. --}}
        {{-- <div x-data="{ statsOverviewStatChart: function () {} }">
            <div
                ax-load
                ax-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('stats-overview/stat/chart', 'filament/widgets') }}"
                x-data="statsOverviewStatChart({
                            dataChecksum: @js($dataChecksum),
                            labels: @js(array_keys($chart)),
                            values: @js(array_values($chart)),
                        })"
                @class([
                    'absolute inset-x-0 bottom-0 overflow-hidden rounded-b-xl',
                    match ($chartColor) {
                        'gray' => '',
                        default => '',
                    },
                ])
                @style([
                    \Filament\Support\get_color_css_variables(
                        $chartColor,
                        shades: [50, 400, 500],
                    ) => $chartColor !== 'gray',
                ])
            >
                <canvas x-ref="canvas" class="h-6"></canvas>

                <span
                    x-ref="backgroundColorElement"
                    @class([
                        match ($chartColor) {
                            'gray' => 'text-gray-100',
                            default => 'text-custom-50',
                        },
                    ])
                ></span>

                <span
                    x-ref="borderColorElement"
                    @class([
                        match ($chartColor) {
                            'gray' => 'text-gray-400',
                            default => 'text-custom-500',
                        },
                    ])
                ></span>
            </div>
        </div> --}}
    {{-- @endif --}}
</{!! $tag !!}>
