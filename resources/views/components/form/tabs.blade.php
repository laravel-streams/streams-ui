@php
    $isContained = true;//$isContained();
@endphp

<div
    wire:ignore.self
    x-cloak
    x-data="{
        tab: null,

        init: function () {
            this.$watch('tab', () => this.updateQueryString())

            this.tab = this.getTabs()[@js($getActiveTab()) - 1]
        },

        getTabs: function () {
            return JSON.parse(this.$refs.tabsData.value)
        },

        updateQueryString: function () {
            {{-- if (! @js($isTabPersistedInQueryString())) {
                return
            } --}}

            const url = new URL(window.location.href)
            {{-- url.searchParams.set(@js($getTabQueryStringKey()), this.tab) --}}

            history.pushState(null, document.title, url.toString())
        },
    }"
    {{
        $attributes
            ->merge([
                'id' => $getId(),
                //'wire:key' => "{$this->getId()}.{$getStatePath()}." . \Streams\Ui\Forms\Layouts\Tabs::class . '.container',
            ], escape: false)
            ->merge($getHtmlAttributes(), escape: false)
            //->merge($getExtraAlpineAttributes(), escape: false)
            ->class([
                'flex flex-col',
                'rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5' => $isContained,
            ])
    }}
>
    <input
        type="hidden"
        value="{{
            // collect($getChildComponentContainer()->getComponents())
            collect($getComponents())
                // ->filter(static fn (\Streams\Ui\Forms\Layouts\Tab $tab): bool => $tab->isVisible())
                ->map(static fn (\Streams\Ui\Forms\Layouts\Tab $tab) => $tab->getId())
                ->values()
                ->toJson()
        }}"
        x-ref="tabsData"
    />

    <x-ui::tabs :contained="$isContained" :label="$getLabel()">
        {{-- @foreach ($getChildComponentContainer()->getComponents() as $tab) --}}
        @foreach ($getComponents() as $tab)
            @php
                $tabId = $tab->getId();
            @endphp

            <x-ui::tabs.item
                :alpine-active="'tab === \'' . $tabId . '\''"
                :badge="$tab->getBadge()"
                :icon="$tab->getIcon()"
                {{-- :icon-position="$tab->getIconPosition()" --}}
                :x-on:click="'tab = \'' . $tabId . '\''"
            >
                {{ $tab->getLabel() }}
            </x-ui::tabs.item>
        @endforeach
    </x-ui::tabs>

    @foreach ($getComponents() as $tab)
        {{ $tab }}
    @endforeach
</div>
