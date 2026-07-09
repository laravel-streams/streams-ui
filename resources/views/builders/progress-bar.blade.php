@php
    $description = $progressBar->getDescription();
    $progress = $progressBar->getProgress();
    $label = $progressBar->getLabel();
    
    $heading = $progressBar->getHeading() ?: 'h3';
@endphp
<div {{ $progressBar->getHtmlAttributeBag()->merge(['class' => 'w-full']) }}>

    @if ($label)
    <{{ $heading }} class="text-xl font-bold">
        {{ $label }}
    </{{ $heading }}>
    @endif
    
    @if ($description)
    <p class="pb-6">{{ $description }}</p>
    @endif

    <div aria-hidden="true">
        <div class="overflow-hidden rounded-full bg-gray-200">
            <div style="width: {{ $progress }}%" class="h-2 rounded-full bg-primary-500"></div>
        </div>
        {{-- <div class="mt-6 hidden grid-cols-5 text-sm font-medium text-gray-600 sm:grid">
            @foreach ($progressBar->getSteps() as $item)
                <div>
                    <div class="{{ $loop->last ? 'text-right' : ($loop->first ? 'text-left' : 'text-center') }}{{ false ? 'text-primary-500' : '' }}">{{ $item->getLabel() }}</div>
                </div>
            @endforeach
        </div> --}}
    </div>
</div>
