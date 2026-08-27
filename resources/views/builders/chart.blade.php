@php
    $heading = $this->getHeading();
    $description = $this->getDescription();
    $ariaLabel = $this->getAriaLabel() ?: $heading;
    $accessibleRows = $this->getAccessibleRows();
    $datasetLabel = $this->getDatasetLabel() ?: __('ui::labels.value');
    $emptyMessage = $this->getEmptyMessage();
    $headingId = 'chart-heading-'.$this->getId();
    $descId = 'chart-desc-'.$this->getId();
    $tableId = 'chart-table-'.$this->getId();
@endphp

{{-- Single root required by Livewire. --}}
<div class="w-full">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

    @foreach ($this->getFunctions() as $functionName => $functionBody)
        <script>
            const {{ $functionName }} = {!! $functionBody !!}
        </script>
    @endforeach

    <figure
        class="w-full rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5"
        @if ($heading) aria-labelledby="{{ $headingId }}" @endif
        @if ($description) aria-describedby="{{ $descId }}" @endif
    >
        @if ($heading || $description)
            <figcaption class="mb-4">
                @if ($heading)
                    <h2 id="{{ $headingId }}" class="text-base font-semibold leading-6 text-gray-950">
                        {{ $heading }}
                    </h2>
                @endif
                @if ($description)
                    <p id="{{ $descId }}" class="mt-1 text-sm text-gray-500">
                        {{ $description }}
                    </p>
                @endif
            </figcaption>
        @endif

        @if (! $this->hasChartData())
            <p class="text-sm text-gray-500" role="status">
                {{ $emptyMessage }}
            </p>
        @else
            <div
                @if ($pollingInterval = $this->getPollingInterval())
                    wire:poll.{{ $pollingInterval }}="updateChartData"
                @endif
            >
                <div
                    x-data="{
                        data: @js($this->getData()),
                        options: @js($this->getOptions()),
                        callbacks: @js($this->getCallbacks()),
                        init() {
                            const ctx = this.$refs.canvas.getContext('2d');

                            if (! this.options) {
                                this.options = {};
                            }

                            if (! this.options.plugins) {
                                this.options.plugins = {};
                            }

                            if (! this.options.plugins.tooltip) {
                                this.options.plugins.tooltip = {};
                            }

                            this.options.plugins.tooltip.callbacks = this.options.plugins.tooltip.callbacks || {};

                            if (this.callbacks && this.callbacks.tooltip) {
                                for (const [key, value] of Object.entries(this.callbacks.tooltip)) {
                                    this.options.plugins.tooltip.callbacks[key] = eval('(' + value + ')');
                                }
                            }

                            const chart = new Chart(ctx, {
                                type: @js($this->getType()),
                                data: {
                                    labels: this.data.labels,
                                    datasets: this.data.datasets,
                                },
                                options: this.options,
                            });

                            if (this.options.onClick) {
                                chart.options.onClick = eval(this.options.onClick);
                            }

                            this.$watch('data', () => {
                                chart.data.labels = this.data.labels;
                                chart.data.datasets = this.data.datasets;
                                chart.update();
                            });
                        }
                    }"
                    class="relative h-72 w-full max-h-96"
                >
                    <canvas
                        x-ref="canvas"
                        role="img"
                        @if ($ariaLabel) aria-label="{{ $ariaLabel }}" @endif
                        aria-describedby="{{ $tableId }}"
                    ></canvas>
                </div>
            </div>

            {{-- Textual equivalent for screen readers and when Chart.js is unavailable --}}
            <div class="sr-only">
                <table id="{{ $tableId }}">
                    @if ($ariaLabel)
                        <caption>{{ $ariaLabel }}</caption>
                    @endif
                    <thead>
                        <tr>
                            <th scope="col">{{ __('ui::labels.label') }}</th>
                            <th scope="col">{{ $datasetLabel }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($accessibleRows as $row)
                            <tr>
                                <td>{{ $row['label'] }}</td>
                                <td>{{ $row['value'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </figure>
</div>
