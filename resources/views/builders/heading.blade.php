@props([
    'priority' => 'h1',
])

@php
    $classes = Arr::toCssClasses([
        match ($priority) {
            'h1' => 'text-3xl',
            default => '',
        },
        // match ($color) {
        //     'gray' => 'text-white',
        //     default => null,
        // },
    ]);
@endphp

<div class="col-span-full flex items-center justify-between">
    <div>
        <{{ $priority }} class="{{ $classes }} font-bold text-gray-900">{{ $heading->getTitle() }}</{{ $priority }}>
        @if ($description = $heading->getDescription())
        <p class="text-gray-500 mt-2">{{ $description }}</p>
        @endif
    </div>
    @foreach ($heading->getActions() as $action)
        {!! $action->render() !!}
    @endforeach
</div>
