@php
    $id = $wizard->getId();
    $label = $wizard->getLabel();
    $steps = $wizard->getSteps();

    $stepsCount = count($steps);
    $isContained = true;
    $statePath = 'wizard';
@endphp

<div
    wire:ignore.self
    x-cloak
    x-data="{
        step: 0,
        stepsCount: @js($stepsCount),

        nextStep() {
            if (this.step >= this.stepsCount - 1) return
            this.step++
            this.$nextTick(() => this.scrollToStep())
        },

        previousStep() {
            if (this.step <= 0) return
            this.step--
            this.$nextTick(() => this.scrollToStep())
        },

        scrollToStep() {
            const header = this.$refs.header
            if (header?.children[this.step]) {
                header.children[this.step].scrollIntoView({ behavior: 'smooth', block: 'start' })
            }
        },
    }"
    x-init="step = {{ $initialStepIndex ?? 0 }}"
    {{
        $attributes
            ->merge([
                'id' => $id,
            ], escape: false)
            ->class([
                'ui-wizard',
                'rounded-xl bg-white shadow-sm ring-1 ring-black/5',
            ])
            ->merge($wizard->getHtmlAttributes(), escape: false)
    }}
>
    {{-- <input
        type="hidden"
        value="{{
            collect($getChildComponentContainer()->getComponents())
                ->filter(static fn (\Filament\Forms\Components\Wizard\Step $step): bool => $step->isVisible())
                ->map(static fn (\Filament\Forms\Components\Wizard\Step $step) => $step->getId())
                ->values()
                ->toJson()
        }}"
        x-ref="stepsData"
    /> --}}

    <ol
        @if (filled($label = $getLabel()))
            aria-label="{{ $label }}"
        @endif
        role="list"
        @class([
            'flex divide-y divide-x divide-gray-200 md:flex-row md:divide-y-0 md:overflow-x-auto',
            'border-b border-gray-200',
        ])
        x-ref="header"
    >
        @foreach ($steps as $step)
            <li
                class="px-4 md:flex md:flex-1"
                x-bind:class="{
                    'ui-active': step === {{ $loop->index }},
                    'ui-completed': step > {{ $loop->index }},
                }"
            >
                @if ($stepUrl = $step->getUrl())
                <a
                    href="{{ $stepUrl }}"
                    id="{{ $id }}-tab-{{ $loop->index }}"
                    x-bind:aria-current="step === {{ $loop->index }} ? 'step' : null"
                    role="step"
                    @if ($step->shouldOpenInNewTab())
                    target="_blank"
                    rel="noopener noreferrer"
                    @endif
                    class="flex h-full items-center gap-x-4 px-6 py-4 text-start"
                    wire:navigate
                >
                @else
                <button
                    type="button"
                    id="{{ $id }}-tab-{{ $loop->index }}"
                    x-bind:aria-current="step === {{ $loop->index }} ? 'step' : null"
                    x-on:click="step = {{ $loop->index }}"
                    role="step"
                    class="flex h-full items-center gap-x-4 px-6 py-4 text-start"
                >
                @endif
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $loop->index === 0 ? 'bg-primary-500' : 'bg-gray-200' }}"
                        x-bind:class="{
                            'bg-primary-600': step > {{ $loop->index }},
                            'border-2': step <= {{ $loop->index }},
                            'border-primary-600': step === {{ $loop->index }},
                            'border-gray-300': step < {{ $loop->index }},
                            'text-white': step > {{ $loop->index }} || (step === {{ $loop->index }} && {{ $loop->index }} === 0),
                            'text-base': step < {{ $loop->index }} || (step === {{ $loop->index }} && {{ $loop->index }} > 0),
                        }"
                    >
                        {{-- @php
                            $completedIcon = $step->getCompletedIcon();
                        @endphp --}}

                        {{-- <x-filament::icon
                            :alias="filled($completedIcon) ? null : 'forms::components.wizard.completed-step'"
                            :icon="$completedIcon ?? 'heroicon-o-check'"
                            x-cloak="x-cloak"
                            x-show="getStepIndex(step) > {{ $loop->index }}"
                            class="ui-wizard-header-step-icon h-6 w-6 text-white"
                        /> --}}

                        {{-- @if (filled($icon = $step->getIcon()))
                            <x-filament::icon
                                :icon="$icon"
                                x-cloak="x-cloak"
                                x-show="getStepIndex(step) <= {{ $loop->index }}"
                                class="ui-wizard-header-step-icon h-6 w-6"
                                x-bind:class="{
                                    'text-gray-500 dark:text-gray-400': getStepIndex(step) !== {{ $loop->index }},
                                    'text-primary-600 dark:text-primary-500': getStepIndex(step) === {{ $loop->index }},
                                }"
                            />
                        @else --}}
                            <span
                                class="text-sm font-medium"
                                x-bind:class="{
                                    'text-white': step > {{ $loop->index }} || (step === {{ $loop->index }} && {{ $loop->index }} === 0),
                                    'text-base': step < {{ $loop->index }} || (step === {{ $loop->index }} && {{ $loop->index }} > 0),
                                }"
                            >
                                {{ str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                        {{-- @endif --}}
                    </div>

                    <div class="grid justify-items-start md:w-max md:max-w-60">
                        @if ($label = $step->getLabel())
                            <span
                                class="text-sm font-medium"
                                x-bind:class="{
                                    'text-gray-500':
                                        step < {{ $loop->index }},
                                    'text-primary-600':
                                        step === {{ $loop->index }},
                                    'text-gray-950': step > {{ $loop->index }},
                                }"
                            >
                                {{ $step->getLabel() }}
                            </span>
                        @endif

                        {{-- @if (filled($description = $step->getDescription()))
                            <span
                                class="ui-wizard-header-step-description text-start text-sm text-gray-500 dark:text-gray-400"
                            >
                                {{ $description }}
                            </span>
                        @endif --}}
                    </div>
                @if ($stepUrl)
                </a>
                @else
                </button>
                @endif

                {{-- @if (! $loop->last)
                    <div
                        aria-hidden="true"
                        class="ui-wizard-header-step-separator absolute end-0 hidden h-full w-5 md:block"
                    >
                        <svg
                            fill="none"
                            preserveAspectRatio="none"
                            viewBox="0 0 22 80"
                            class="h-full w-full text-gray-200 rtl:rotate-180"
                        >
                            <path
                                d="M0 -2L20 40L0 82"
                                stroke-linejoin="round"
                                stroke="currentcolor"
                                vector-effect="non-scaling-stroke"
                            ></path>
                        </svg>
                    </div>
                @endif --}}
            </li>
        @endforeach
    </ol>

    @foreach ($steps as $step)
    <div
        x-bind:tabindex="$el.querySelector('[autofocus]') ? '-1' : '0'"
        x-show="step === {{ $loop->index }}"
        x-transition
        role="tabpanel"
        aria-labelledby="{{ $id }}-tab-{{ $loop->index }}"
        id="{{ $id }}-panel-{{ $loop->index }}"
        class="outline-none"
    >
        @foreach ($step->getComponents() as $component)
        @if (is_string($component))
            @livewire($component)
        @else
            {!! $component->render() !!}
        @endif
        @endforeach
    </div>
    @endforeach

    <div
        @class([
            'flex items-center justify-between gap-x-3',
            'px-6 pb-6' => $isContained,
            'mt-6' => ! $isContained,
        ])
    >
        {{-- <span
            x-cloak
            @if (! $previousAction->isDisabled())
                x-on:click="previousStep"
            @endif
            x-show="! isFirstStep()"
        >
            {{ $previousAction }}
        </span> --}}

        {{-- <span x-show="isFirstStep()">
            {{ $getCancelAction() }}
        </span>

        <span
            x-cloak
            @if (! $nextAction->isDisabled())
                x-on:click="
                    $wire.dispatchFormEvent(
                        'wizard::nextStep',
                        '{{ $statePath }}',
                        getStepIndex(step),
                    )
                "
            @endif
            x-bind:class="{ 'hidden': isLastStep(), 'block': ! isLastStep() }"
            wire:loading.class="pointer-events-none opacity-70"
        >
            {{ $nextAction }}
        </span> --}}

        {{-- <span
            x-bind:class="{ 'hidden': ! isLastStep(), 'block': isLastStep() }"
        >
            {{ $getSubmitAction() }}
        </span> --}}
    </div>
</div>
