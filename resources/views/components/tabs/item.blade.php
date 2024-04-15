@props([
    'active' => false,
    'alpineActive' => null,
    'badge' => null,
    'badgeColor' => null,
    'href' => null,
    'icon' => null,
    'iconColor' => 'gray',
    'iconPosition' => 'before',
    'tag' => 'button',
    'target' => null,
    'type' => 'button',
])

@php
    $hasAlpineActiveClasses = filled($alpineActive);

    $inactiveItemClasses = 'hover:bg-gray-100 focus-visible:bg-gray-100';

    $activeItemClasses = 'bg-gray-100';

    $inactiveLabelClasses = 'text-gray-500 group-hover:text-gray-700 group-focus-visible:text-gray-700';

    $activeLabelClasses = 'text-primary-600';

    $iconClasses = 'h-5 w-5 shrink-0 transition duration-75';

    $inactiveIconClasses = 'text-gray-400';

    $activeIconClasses = 'text-primary-600';
@endphp

<{{ $tag }}
    @if ($tag === 'button')
        type="{{ $type }}"
    @elseif ($tag === 'a')
        href="{{ $href }}"
        target="{{ $target }}"
    @endif
    @if ($hasAlpineActiveClasses)
        x-bind:class="{
            @js($inactiveItemClasses): ! {{ $alpineActive }},
            @js($activeItemClasses): {{ $alpineActive }},
        }"
    @endif
    {{
        $attributes
            ->merge([
                'aria-selected' => $active,
                'role' => 'tab',
            ])
            ->class([
                'group flex items-center gap-x-2 rounded-lg px-3 py-2 text-sm font-medium outline-none transition duration-75',
                $inactiveItemClasses => (! $hasAlpineActiveClasses) && (! $active),
                $activeItemClasses => (! $hasAlpineActiveClasses) && $active,
            ])
    }}
>
    @if ($icon && $iconPosition === IconPosition::Before)
        <x-ui::icon
            :icon="$icon"
            :x-bind:class="$hasAlpineActiveClasses ? '{ ' . \Illuminate\Support\Js::from($inactiveIconClasses) . ': ! (' . $alpineActive . '), ' . \Illuminate\Support\Js::from($activeIconClasses) . ': ' . $alpineActive . ' }' : null"
            @class([
                $iconClasses,
                $inactiveIconClasses => (! $hasAlpineActiveClasses) && (! $active),
                $activeIconClasses => (! $hasAlpineActiveClasses) && $active,
            ])
        />
    @endif

    <span
        @if ($hasAlpineActiveClasses)
            x-bind:class="{
                @js($inactiveLabelClasses): ! {{ $alpineActive }},
                @js($activeLabelClasses): {{ $alpineActive }},
            }"
        @endif
        @class([
            'transition duration-75',
            $inactiveLabelClasses => (! $hasAlpineActiveClasses) && (! $active),
            $activeLabelClasses => (! $hasAlpineActiveClasses) && $active,
        ])
    >
        {{ $slot }}
    </span>

    @if ($icon && $iconPosition === IconPosition::After)
        <x-ui::icon
            :icon="$icon"
            :x-bind:class="$hasAlpineActiveClasses ? '{ ' . \Illuminate\Support\Js::from($inactiveIconClasses) . ': ! (' . $alpineActive . '), ' . \Illuminate\Support\Js::from($activeIconClasses) . ': ' . $alpineActive . ' }' : null"
            @class([
                $iconClasses,
                $inactiveIconClasses => (! $hasAlpineActiveClasses) && (! $active),
                $activeIconClasses => (! $hasAlpineActiveClasses) && $active,
            ])
        />
    @endif

    @if (filled($badge))
        <x-ui::badge :color="$badgeColor" size="sm" class="w-max">
            {{ $badge }}
        </x-ui::badge>
    @endif
    
</{{ $tag }}>
