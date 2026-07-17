@php
    $radiusClass = $borderRadiusClass ?: 'rounded-full';
    $navClasses = Arr::toCssClasses([
        'inline-flex items-center gap-x-1 p-1',
        $radiusClass,
        'border border-gray-200 bg-white' => $isOutlined,
    ]);
@endphp
<nav aria-label="Tabs" @class([$navClasses])>
  @foreach ($items as $item)
    @php
      $isActive = $item->isActive();
      $isDisabled = $item->isDisabled();
      $itemClasses = Arr::toCssClasses([
          'group inline-flex items-center gap-x-2 px-3 py-2 text-sm font-medium whitespace-nowrap transition',
          $radiusClass,
          "{$activeColorClasses['bg']} text-white shadow-sm" => $isActive && ! $isDisabled,
          'text-gray-600 hover:bg-gray-100 hover:text-gray-900' => ! $isActive && ! $isDisabled,
          'text-gray-300 cursor-not-allowed pointer-events-none' => $isDisabled,
      ]);
      $iconClass = $isActive && ! $isDisabled
          ? 'text-white'
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
