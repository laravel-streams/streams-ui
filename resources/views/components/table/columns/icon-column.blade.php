<div
    {{
        $attributes
            ->merge($getHtmlAttributes(), escape: false)
            ->class([
                'flex flex-wrap justify-center gap-1.5',
                // 'px-3 py-4' => ! $isInline(),
                // 'flex-col' => $isListWithLineBreaks(),
            ])
    }}
>
    {{-- @if (count($arrayState = \Illuminate\Support\Arr::wrap($getState())))
        @foreach ($arrayState as $state) --}}
            @if ($icon = $getIcon($state ?? null))
                @php
                    $color = $getColor($state) ?? 'gray';
                    $size = $getSize($state) ?? 'lg';
                @endphp

                <x-ui::icon
                    :icon="$icon"
                    @class([
                        'ui-column-icon',
                        match ($size) {
                            'xs' => 'h-3 w-3',
                            'sm' => 'h-4 w-4',
                            'md' => 'h-5 w-5',
                            'lg' => 'h-6 w-6',
                            'xl' => 'h-7 w-7',
                            default => $size,
                        },
                        ...match ($color) {
                            null => [
                                'text-gray-500 hover:text-gray-600',
                            ],
                            default => [
                                'text-custom-500 hover:text-custom-600',
                            ],
                        },
                    ])
                    @style([
                        \Streams\Ui\Support\Facades\Colors::colorVariables(
                            $color,
                            shades: [400, 500, 600],
                        ) => $color !== 'gray',
                    ])
                />
            @endif
        {{-- @endforeach
    @elseif (($placeholder = $getPlaceholder()) !== null)
        <x-ui::columns.placeholder>
            {{ $placeholder }}
        </x-ui::columns.placeholder>
    @endif --}}
</div>
