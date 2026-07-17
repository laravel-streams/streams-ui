<div class="border-b border-gray-200">
  <nav aria-label="Tabs" class="-mb-px flex space-x-8">
    @foreach ($items as $item)
      @php
        $isActive = $item->isActive();
        $isDisabled = $item->isDisabled();
        $itemClasses = Arr::toCssClasses([
            'group inline-flex items-center gap-x-2 px-1 py-4 text-sm font-medium whitespace-nowrap',
            $activeColorClasses['text'] => $isActive && ! $isDisabled,
            'text-gray-500 hover:text-gray-700' => ! $isActive && ! $isDisabled,
            'text-gray-300 cursor-not-allowed pointer-events-none' => $isDisabled,
        ]);
        $iconClass = $isActive && ! $isDisabled
            ? $activeColorClasses['text']
            : ($isDisabled ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-500');
      @endphp
      <a
        href="{{ $isDisabled ? '#' : $item->getUrl() }}"
        @if ($isActive) aria-current="page" @endif
        @if ($isDisabled) aria-disabled="true" tabindex="-1" @endif
        @if ($item->shouldOpenInNewTab()) target="_blank" rel="noopener noreferrer" @endif
        {{ $item->getHtmlAttributeBag()->class([$itemClasses]) }}
      >
        @include('ui::builders.navigation.partials.item-content', [
            'item' => $item,
            'iconClass' => $iconClass,
        ])
      </a>
    @endforeach
  </nav>
</div>
