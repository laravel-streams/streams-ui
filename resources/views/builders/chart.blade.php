@php
$heading = $this->getHeading();
$description = $this->getDescription();
// $filters = $this->getFilters();
@endphp

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/moment@^2"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@^1"></script>


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

        <div @if ($pollingInterval=$this->getPollingInterval())
            wire:poll.{{ $pollingInterval }}="updateChartData"
            @endif
            >
            <div x-data="{
                data: @js($this->getData()),
                init() {
                    let chart = new Chart(this.$refs.canvas.getContext('2d'), {
                        type: @js($this->getType()),
                        data: {
                            labels: this.data.labels,
                            datasets: this.data.datasets,
                        },
                        options: @js($this->getOptions())
                    })
         
                    this.$watch('data', () => {
                        chart.data.labels = this.data.labels
                        chart.data.datasets = this.data.datasets
                        chart.update()
                    })
                }
            }" class="w-full">
            
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
