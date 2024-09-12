@php
    use Illuminate\Pagination\LengthAwarePaginator;
@endphp

@props([
    'paginator',
    'paginationOptions' => [],
    'currentPageOption' => 'tableRecordsPerPage',
])

<tfoot>
    <tr>
        <td colspan="100%">
            <div class="text-left px-6 py-4 flex w-full justify-between items-center">

                @if (!$paginator instanceof LengthAwarePaginator && !$paginator->onFirstPage())
                <div>
                    <button wire:click="previousPage('{{ $this->getTablePaginationPageName() }}')">Previous</button>
                </div>
                @endif

                @if ($paginator instanceof LengthAwarePaginator)
                <div class="flex-grow-1">
                    Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ number_format($paginator->total()) }} results.
                </div>
                @endif

                <div>

                    @if (count($paginationOptions) > 1)
                    <label>
                        <div
                            class="flex rounded-lg shadow-sm ring-1 transition duration-75 bg-white focus-within:ring-2 ring-gray-950/10 focus-within:ring-primary-600">
                            <div class="items-center gap-x-3 flex border-e border-gray-200 pe-3 ps-3">

                                <span class="whitespace-nowrap text-sm text-gray-500">
                                    Per Page
                                </span>
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="col-start-2 justify-self-center">
                                    <label>
                                        <x-ui::inputs.native-select
                                            wire:key="currentPagination"
                                            :wire:model.live="$currentPageOption">
                                            @foreach ($paginationOptions as $option)
                                            <option value="{{ $option }}" {{ $this->{$currentPageOption} == $option ? 'selected' : null }}>
                                                {{ $option === 'all' ?
                                                __('All') :
                                                $option }}
                                            </option>
                                            @endforeach
                                        </x-ui::inputs.native-select>

                                        <span class="sr-only">
                                            {{ __('Per Page') }}
                                        </span>
                                    </label>
                                </div>

                            </div>

                        </div>
                    </label>
                    @endif

                </div>

                <div>
                    <x-ui::pagination
                        :paginator="$paginator"
                        :isSimple="$paginator instanceof LengthAwarePaginator"
                        class="px-3 py-3 sm:px-6" />
                </div>

            </div>
        </td>
    </tr>
</tfoot>
