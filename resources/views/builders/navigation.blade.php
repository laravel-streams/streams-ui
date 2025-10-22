<div>
  <div class="grid grid-cols-1 sm:hidden">
    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
    <select aria-label="Select a tab"
      class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-2 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-primary-600">
      @foreach ($navigation->getItems() as $item)
      <option value="{{ $item->getUrl() }}" {{ $item->isActive() ? 'selected' : '' }}>{{ $item->getLabel() }}</option>
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
    <div _class="border-b border-gray-200">
      <nav aria-label="Tabs" class="-mb-px flex space-x-8">
        @foreach ($navigation->getItems() as $item)
        <a href="{{ $item->getUrl() }}" {{ $item->isActive() ? 'aria-current="page"' : '' }} class="flex border-b-2 px-1 py-4
          font-medium whitespace-nowrap {{ $item->isActive() ? 'border-primary-500 text-primary-600' :
          'border-transparent hover:text-gray-700 hover:border-gray-400' }}">{{ $item->getLabel() }}
          @if ($badge = $item->getBadge())
          <div class="flex justify-center items-center">
            <x-ui::badge class="ml-2" size="xs">{{ $badge }}</x-ui::badge>
          </div>
          @endif</a>
        @endforeach
      </nav>
    </div>
  </div>
</div>
