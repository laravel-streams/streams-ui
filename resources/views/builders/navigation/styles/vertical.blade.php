<nav aria-label="Navigation">
  <ul role="list" class="space-y-1">
    @foreach ($items as $item)
      @php
        $isActive = $item->isActive();
        $isDisabled = $item->isDisabled();
        $itemClasses = Arr::toCssClasses([
            'group flex w-full items-center gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition-colors',
            "bg-gray-50 {$activeColorClasses['text']}" => $isActive && ! $isDisabled,
            'text-gray-700 hover:bg-gray-50 hover:text-gray-900' => ! $isActive && ! $isDisabled,
            'text-gray-300 cursor-not-allowed pointer-events-none' => $isDisabled,
        ]);
        $iconClass = $isActive && ! $isDisabled
            ? $activeColorClasses['text']
            : ($isDisabled ? 'text-gray-300' : 'text-gray-400 group-hover:text-gray-500');
      @endphp
      <li>
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
              'badgeClass' => 'ml-auto',
          ])
        </a>
      </li>
    @endforeach
  </ul>
</nav>
