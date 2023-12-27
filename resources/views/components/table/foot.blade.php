@props([
    'paginator',
    'paginationOptions' => [],
    'currentPageOption' => 'getTableEntriesPerPage',
])

<tfoot>
    <tr>
        <td colspan="100%" class="text-left px-6 py-4 flex justify-between items-center">
            <div>
                Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ number_format($paginator->total()) }} results.
            </div>
            <div>

                <label>
                    <div
                        class="flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 ring-gray-950/10 focus-within:ring-primary-600">
                        <div class="items-center gap-x-3 flex border-e border-gray-200 pe-3 ps-3">

                            <span class="whitespace-nowrap text-sm text-gray-500">
                                Per Page
                            </span>
                        </div>

                        <div class="min-w-0 flex-1">

                            @if (count($paginationOptions) > 1)
                            <div class="col-start-2 justify-self-center">
                                <label>
                                    <select wire:model.live="currentPageOption">
                                        @foreach ($paginationOptions as $option)
                                        <option value="{{ $option }}">
                                            {{ $option === 'all' ?
                                            __('All') :
                                            $option }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <span class="sr-only">
                                        {{ __('Per Page') }}
                                    </span>
                                </label>
                            </div>
                            @endif

                        </div>

                    </div>
                </label>

            </div>
            <div>
                <x-ui::pagination :paginator="$paginator" class="px-3 py-3 sm:px-6" />
            </div>
        </td>
    </tr>
</tfoot>
