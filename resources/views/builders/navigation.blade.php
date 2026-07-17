@php
    $style = $navigation->getStyle() ?: 'underline';
    $allowedStyles = ['underline', 'simple', 'pills', 'bar'];

    if (! in_array($style, $allowedStyles, true)) {
        $style = 'underline';
    }

    $activeColor = $navigation->getActiveColor() ?: 'primary';
    $activeColorClasses = $navigation->getActiveColorClasses();
    $borderRadiusClass = $navigation->getBorderRadiusClass();
    $isOutlined = $navigation->isOutlined();
    $items = $navigation->getItems();
@endphp
<div {{ $attributes->merge($navigation->getHtmlAttributes())->class(['w-full']) }}>
  <div class="grid grid-cols-1 sm:hidden">
    <select
      aria-label="Select a tab"
      onchange="if (this.value) { window.location = this.value }"
      class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-primary-600"
    >
      @foreach ($items as $item)
        @continue($item->isDisabled())
        <option value="{{ $item->getUrl() }}" {{ $item->isActive() ? 'selected' : '' }}>
          {{ $item->getLabel() }}
        </option>
      @endforeach
    </select>
    <svg viewBox="0 0 16 16" fill="currentColor" data-slot="icon" aria-hidden="true"
      class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end fill-gray-500">
      <path
        d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
        clip-rule="evenodd" fill-rule="evenodd" />
    </svg>
  </div>

  <div class="hidden sm:block">
    @include("ui::builders.navigation.styles.{$style}", [
        'navigation' => $navigation,
        'items' => $items,
        'activeColor' => $activeColor,
        'activeColorClasses' => $activeColorClasses,
        'borderRadiusClass' => $borderRadiusClass,
        'isOutlined' => $isOutlined,
    ])
  </div>
</div>
