@props([
    'field' => null,
    'hasInlineLabel' => null,
    'hasNestedRecursiveValidationRules' => null,
    'helpText' => null,
    'hint' => null,
    'hintActions' => null,
    'hintColor' => null,
    'hintIcon' => null,
    'hintIconTooltip' => null,
    'id' => null,
    'isDisabled' => null,
    'isMarkedAsRequired' => null,
    'label' => null,
    'labelPrefix' => null,
    'labelSrOnly' => null,
    'labelSuffix' => null,
    'required' => null,
    'statePath' => null,
])

@php
    if ($field) {
        // $hasInlineLabel ??= $field->hasInlineLabel();
        // $hasNestedRecursiveValidationRules ??= $field instanceof \Filament\Forms\Components\Contracts\HasNestedRecursiveValidationRules;
        $helpText ??= $field->getHelpText();
        $hint ??= $field->getHint();
        // $hintActions ??= $field->getHintActions();
        // $hintColor ??= $field->getHintColor();
        $hintIcon ??= $field->getHintIcon();
        // $hintIconTooltip ??= $field->getHintIconTooltip();
        $id ??= $field->getId();
        $isDisabled ??= $field->isDisabled();
        // $isMarkedAsRequired ??= $field->isMarkedAsRequired();
        $label ??= $field->getLabel();
        // $labelSrOnly ??= $field->isLabelHidden();
        $required ??= $field->isRequired();
        $statePath ??= $field->getStatePath();
    }

    // $hintActions = array_filter(
    //     $hintActions ?? [],
    //     fn (\Filament\Forms\Components\Actions\Action $hintAction): bool => $hintAction->isVisible(),
    // );

    // $hasError = $errors->has($statePath) || ($hasNestedRecursiveValidationRules && $errors->has("{$statePath}.*"));
    $hasError = $errors->has($statePath) || $errors->has("{$statePath}.*");
@endphp

<div {{ $attributes->class([]) }}>
    @if ($label && $labelSrOnly)
        <label for="{{ $id }}" class="sr-only">
            {{ $label }}
        </label>
    @endif

    <div
        @class([
            'grid gap-y-2',
            'sm:grid-cols-3 sm:items-start sm:gap-x-4' => $hasInlineLabel,
        ])
    >
        {{-- @if (($label && (! $labelSrOnly)) || $labelPrefix || $labelSuffix || filled($hint) || $hintIcon || count($hintActions)) --}}
        @if ($label)
            <div
                @class([
                    'flex items-center justify-between gap-x-3',
                    'sm:pt-1.5' => $hasInlineLabel,
                ])
            >
                @if ($label && (! $labelSrOnly))
                    <x-ui::field.label
                        :for="$id"
                        :error="$errors->has($statePath)"
                        :is-disabled="$isDisabled"
                        :is-marked-as-required="$isMarkedAsRequired"
                        :prefix="$labelPrefix"
                        :suffix="$labelSuffix"
                        :required="$required"
                    >
                        {{ $label }}
                    </x-ui::field.label>
                @elseif ($labelPrefix)
                    {{ $labelPrefix }}
                @elseif ($labelSuffix)
                    {{ $labelSuffix }}
                @endif

                @if (
                    filled($hint)
                    || $hintIcon
                    //|| count($hintActions)
                    )
                    <x-ui::field.hint
                        :actions="$hintActions"
                        :color="$hintColor"
                        :icon="$hintIcon"
                        :tooltip="$hintIconTooltip"
                    >
                        {{ $hint }}
                    </x-ui::field.hint>
                @endif
            </div>
        @endif

        @if ($slot || $hasError || filled($helpText))
            <div
                @class([
                    'grid gap-y-2',
                    'sm:col-span-2' => $hasInlineLabel,
                ])
            >
                {{ $slot }}

                @if ($hasError)
                    <x-ui::field.error>
                        {{ $errors->has($statePath) ? $errors->first($statePath) : ($hasNestedRecursiveValidationRules ? $errors->first("{$statePath}.*") : null) }}
                    </x-ui::field.error>
                @endif

                @if (filled($helpText))
                    <x-ui::field.help>
                        {{ $helpText }}
                    </x-ui::field.help>
                @endif
            </div>
        @endif
    </div>
</div>
