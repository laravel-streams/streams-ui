@props([
    'paginator',
    'pageOptions' => [
        5,
        10,
        25,
        50,
        'all',
    ],
    'isSimple' => false,
    'isRtl' => false,
])

<nav
    aria-label="Pagination"
    role="navigation"
    {{
        $attributes->class([
            'items-center gap-x-3',
        ])
    }}
>
    @if ($paginator->hasPages())
        <ol
            class="flex justify-self-end rounded-lg bg-white shadow-sm ring-1 ring-gray-950/10">
            @if (! $paginator->onFirstPage())
                <x-ui::pagination.item
                    :aria-label="__('Previous Page')"
                    :label="__('Previous Page')"
                    :icon="$isRtl ? 'heroicon-m-chevron-right' : 'heroicon-m-chevron-left'"
                    {{-- :icon-alias="$isRtl ? ['pagination.previous-button.rtl', 'pagination.previous-button'] : 'pagination.previous-button'" --}}
                    rel="prev"
                    :wire:click="'previousPage(\'' . $paginator->getPageName() . '\')'"
                    :wire:key="$this->getId() . '.pagination.previous'"
                />
            @endif

            @if (!$isSimple)
            @foreach ($paginator->render()->offsetGet('elements') as $element)
                @if (is_string($element))
                    <x-ui::pagination.item disabled :label="$element" />
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <x-ui::pagination.item
                            :label="$page"
                            :active="$page === $paginator->currentPage()"
                            :aria-label="trans_choice('Go to page :page', $page, ['page' => $page])"
                            :wire:click="'gotoPage(' . $page . ', \'' . $paginator->getPageName() . '\')'"
                            :wire:key="$this->getId() . '.pagination.' . $paginator->getPageName() . '.' . $page"
                        />
                    @endforeach
                @endif
            @endforeach
            @endif

            @if ($paginator->hasMorePages())
                <x-ui::pagination.item
                    :aria-label="__('Next Page')"
                    :label="__('Next Page')"
                    :icon="$isRtl ? 'heroicon-m-chevron-left' : 'heroicon-m-chevron-right'"
                    {{-- :icon-alias="$isRtl ? ['pagination.next-button.rtl', 'pagination.next-button'] : 'pagination.next-button'" --}}
                    rel="next"
                    :wire:click="'nextPage(\'' . $paginator->getPageName() . '\')'"
                    :wire:key="$this->getId() . '.pagination.next'"
                />
            @endif
        </ol>
    @endif
</nav>
