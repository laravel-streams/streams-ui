@php
$heading = $this->getHeading();
$description = $this->getDescription();
// $filters = $this->getFilters();
@endphp

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>

<x-ui::widget>
    
    <x-ui::section :description="$description" :heading="$heading">

        {{-- @if ($filters)
        <x-slot name="headerEnd">
            <x-ui::input.wrapper inline-prefix wire:target="filter" class="-my-2">
                <x-ui::input.select inline-prefix wire:model.live="filter">
                    @foreach ($filters as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                    @endforeach
                </x-ui::input.select>
            </x-ui::input.wrapper>
        </x-slot>
        @endif --}}

        @foreach($this->getFunctions() as $functionName => $functionBody)
        <script>
            const {{$functionName}} = {!!$functionBody!!}
        </script>
        @endforeach

        <div @if ($pollingInterval=$this->getPollingInterval())
            wire:poll.{{ $pollingInterval }}="updateChartData"
            @endif
            >

            <div x-data="{
                data: @js($this->getData()),
                options: @js($this->getOptions()),
                callbacks: @js($this->getCallbacks()),
                init() {

                    let ctx = this.$refs.canvas.getContext('2d');

                    let chart = new Chart(ctx, {
                        type: @js($this->getType()),
                        data: {
                            labels: this.data.labels,
                            datasets: this.data.datasets,
                        },
                        options: this.options
                    })

                    this.options.plugins.tooltip.callbacks = {};

                    if (typeof this.callbacks.tooltip !== undefined) {
                        for (const [key, value] of Object.entries(this.callbacks.tooltip)) {
                            if (typeof this.callbacks.tooltip[key] !== undefined) {
                                this.options.plugins.tooltip.callbacks[key] = eval('(' + this.callbacks.tooltip[key] + ')');
                            }
                        }
                    }

                    if (typeof this.options.onClick !== undefined) {
                        chart.options.onClick = eval(this.options.onClick);
                    }
         
                    this.$watch('data', () => {
                        chart.data.labels = this.data.labels;
                        chart.data.datasets = this.data.datasets;
                        chart.update();
                    })

                    {{-- Livewire.on('$refresh', () => {
                    
                        this.data = @js($this->getData());
                        chart.destroy();
                        alert(this.data.domain);
                        chart.data.labels = this.data.labels;
                        chart.data.datasets = this.data.datasets;
                    }) --}}
                }
            }" class="w-full max-h-96">

                <canvas x-ref="canvas" {{-- @if ($maxHeight=$this->getMaxHeight())
                    style="max-height: {{ $maxHeight }}"
                    @endif --}}
                    ></canvas>

                {{-- <span x-ref="backgroundColorElement" @class([ match ($color) { 'gray'=> 'text-gray-100
                    dark:text-gray-800',
                    default => 'text-custom-50 dark:text-custom-400/10',
                    },
                    ])
                    ></span>

                <span x-ref="borderColorElement" @class([ match ($color) { 'gray'=> 'text-gray-400',
                    default => 'text-custom-500 dark:text-custom-400',
                    },
                    ])
                    ></span> --}}

                {{-- <span x-ref="gridColorElement" class="text-gray-200 dark:text-gray-800"></span>

                <span x-ref="textColorElement" class="text-gray-500 dark:text-gray-400"></span> --}}
            </div>
        </div>
    </x-ui::section>
</x-ui::widget>
