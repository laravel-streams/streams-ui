<tr class="hover:bg-gray-50 cursor-pointer">
    @foreach ($columns as $index => $column)
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 {{ $loop->first ? 'w-1' : '' }}">
        {!! $column->entry($entry)->value() !!}
    </td>
    @endforeach
    @if ($actions)
    <td class="whitespace-nowrap py-4 pr-4 pl-3 text-sm font-medium text-gray-900 sm:pl-6">
        @foreach ($actions as $action)
        <a href="{!! $action->entry($entry)->getUrl() !!}"
            class="bold hover:underline"
            target="{{ $action->shouldOpenInNewTab() ? '_blank' : '_self' }}">{{ $action->getLabel() }}</a>
        @endforeach
    </td>
    @endif
</tr>
