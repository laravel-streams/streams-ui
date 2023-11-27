@props([
    'alpineValid' => null,
    'valid' => true,
    'label',
])

@php
    $hasAlpineValidClasses = filled($alpineValid);

    $validInputClasses = 'text-primary-600 ring-gray-950/10 focus:ring-primary-600 checked:focus:ring-primary-500/50';
    $invalidInputClasses = 'text-danger-600 ring-danger-600 focus:ring-danger-600 checked:focus:ring-danger-500/50';
@endphp

<input
    type="checkbox"
    @if ($hasAlpineValidClasses)
        x-bind:class="{
            @js($validInputClasses): {{ $alpineValid }},
            @js($invalidInputClasses): {{ "(! {$alpineValid})" }},
        }"
    @endif
    {!!
        $attributes
            ->class([
                'rounded border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400',
                $validInputClasses => (! $hasAlpineValidClasses) && $valid,
                $invalidInputClasses => (! $hasAlpineValidClasses) && (! $valid),
            ])
    !!}
/>

<label for="{{ $attributes->get('id') }}" class="cursor-pointer">
    {!! $label !!}
</label>
