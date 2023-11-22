<tr class="hover:bg-gray-50 cursor-pointer">
    @foreach ($columns as $index => $column)
    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
        {!! $column->entry($entry)->value() !!}
    </td>
    @endforeach
    @if ($actions)
    <td>
        @foreach ($actions as $action)
        <a href="{!! $action->entry($entry)->getUrl() !!}"
            target="{{ $action->shouldOpenInNewTab() ? '_blank' : '_self' }}">{{ $action->getLabel() }}</a>
        @endforeach
    </td>
    @endif
</tr>
