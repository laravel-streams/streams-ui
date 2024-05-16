@props([
    'active' => false,
    'ariaLabel' => null,
    'disabled' => false,
    'icon' => null,
    'iconAlias' => null,
    'label' => null,
    'isRtl' => false,
])

<li
    {{
        $attributes->class([
            'group/item border-x-[0.5px] border-gray-200 first:border-s-0 last:border-e-0',
            '' => $disabled,
            '' => $active,
        ])
    }}
>
    <button
        aria-label="{{ $ariaLabel }}"
        @disabled($disabled)
        type="button"
        @class([
            'group/button relative flex items-center overflow-hidden p-2 outline-none transition duration-75 group-first/item:rounded-s-lg group-last/item:rounded-e-lg',
            'hover:bg-gray-50 focus-visible:z-10 focus-visible:ring-2 focus-visible:ring-primary-600' => ! $disabled,
            'bg-gray-50' => $active,
        ])
    >
        @if (filled($icon))
            <x-ui::icon
                :alias="$iconAlias"
                :icon="$icon"
                class="h-5 w-5 text-gray-400 transition duration-75 group-hover/button:text-gray-500"
            />
        @endif

        @if (filled($label))
            <span
                @class([
                    'px-1.5 font-semibold',
                    'text-gray-700' => ! ($disabled || $active),
                    'text-gray-500' => $disabled,
                    'text-primary-600' => $active,
                ])
            >
                {{ $label ?? '...' }}
            </span>
        @endif
    </button>
</li>
