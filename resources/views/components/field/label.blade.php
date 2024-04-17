@props([
    'error' => false,
    'isDisabled' => false,
    'isMarkedAsRequired' => true,
    'prefix' => null,
    'required' => false,
    'suffix' => null,
])

<label
    {{ $attributes->class(['inline-flex items-center gap-x-3']) }}
>
    {{ $prefix }}

    <span class="font-medium leading-6 text-gray-950">
        {{-- Deliberately poor formatting to ensure that the asterisk sticks to the final word in the label. --}}
        {{ $slot }}@if ($required && $isMarkedAsRequired && ! $isDisabled)<sup class="text-danger-600 text-red-600 font-medium">*</sup>
        @endif
    </span>

    {{ $suffix }}
</label>
