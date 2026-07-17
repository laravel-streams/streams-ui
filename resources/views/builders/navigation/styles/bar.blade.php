@php
    $radiusClass = $borderRadiusClass ?: 'rounded-md';
    $navClasses = Arr::toCssClasses([
        'inline-flex w-full divide-x divide-gray-200 overflow-hidden border border-gray-200 bg-white',
        $radiusClass,
    ]);
@endphp
<nav aria-label="Tabs" @class([$navClasses])>
  @foreach ($items as $item)
    @php
      $isActive = $item->isActive();
      $isDisabled = $item->isDisabled();
      $itemClasses = Arr::toCssClasses([
          'group relative inline-flex flex-1 items-center justify-center gap-x-2 border-b-2 px-4 py-3 text-sm whitespace-nowrap transition',
          "{$activeColorClasses['border']} font-semibold text-gray-900" => $isActive && ! $isDisabled,
          'border-transparent font-medium text-gray-500 hover:bg-gray-50 hover:text-gray-700' => ! $isActive && ! $isDisabled,
          'border-transparent font-medium text-gray-300 cursor-not-allowed pointer-events-none' => $isDisabled,
      ]);
      $iconClass = $isActive && ! $isDisabled
          ? 'text-gray-700'
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
