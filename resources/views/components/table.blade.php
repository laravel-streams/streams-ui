<div class="w-full">

    {{-- @if ($this->filters)
    <form method="GET">
        <div class="table__filters flex space-x-2 my-4">
            @foreach ($this->filters as $filter)
            @ui(Arr::pull($filter, 'filter', 'table.filter'), $filter)
            @endforeach
            <button type="submit" class="button">Filter</button>
            <a class="button" href="{{ Request::url() }}">Clear</a>
        </div>
    </form>
    @endif --}}

    <form>

        {{-- @if ($this->views)
        <div class="table__views flex space-x-2 my-4">
            @foreach ($this->views as $view)
            @ui(Arr::pull($view, 'view', 'anchor'), array_merge(
            $view,
            [
            'url' => URL::to(Request::path()) . '?view=' . $view['handle'],
            ]
            ))
            @endforeach
        </div>
        @endif --}}

        <div
            class="w-full divide-y divide-gray-200 overflow-hidden rounded bg-white shadow-sm ring-1 ring-gray-950/5">
            <table>
                <thead>
                    <tr>
                        <th><span class="sr-only">Select Rows</span></th>
                        @foreach ($this->getColumns() as $column)
                        <th>{{ $column->getName() }}</th>
                        @endforeach
                        @if ($this->getButtons())
                        <th><span class="sr-only">Actions</span></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->getEntries() as $entry)
                    <td class="p-2"><input type="checkbox" class="text-indigo-500 border-2 border-indigo-500 rounded"/></td>
                    @foreach ($this->getColumns() as $column)
                    <td>{!! $column->value($entry) !!}</td>
                    @endforeach
                    <td></td>
                    @endforeach
                </tbody>
                <tfoot>
                    {{-- @if ($this->actions)
                    <tr>
                        <td colspan="100%">
                            <div class="table__actions">
                                @foreach ($this->actions as $action)
                                @ui(Arr::pull($action, 'action', 'button'), Arr::parse($action, [
                                'entry' => $this->entry,
                                ]))
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @endif --}}
                    <tr>
                        <td colspan="100%">
                            <div>

                                @if (isset($this->pagination['links']))
                                <div class="table__pagination">
                                    {!! $this->pagination['links']() !!}
                                </div>
                                @endif

                                @if (isset($this->pagination['total']))
                                <small class="table__meta">
                                    {{ $this->pagination['total'] }}
                                    {{ trans_choice('ui::labels.results', $this->pagination['total']) }}
                                </small>
                                @endif

                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </form>

</div>
