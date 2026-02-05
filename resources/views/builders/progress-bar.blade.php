@php
    $progress = $progressBar->getProgress();
@endphp
<div class="w-full">
    
    <p class="text-sm font-medium text-gray-900">{{ $progressBar->getLabel() }}</p>

    <div aria-hidden="true" class="mt-6">
        <div class="overflow-hidden rounded-full bg-gray-200">
            <div style="width: {{ $progress }}%" class="h-2 rounded-full bg-primary-500"></div>
        </div>
        <div class="mt-6 hidden grid-cols-5 text-sm font-medium text-gray-600 sm:grid">
            @foreach ($progressBar->getSteps() as $item)
                <div>
                    <div class="{{ $loop->last ? 'text-right' : ($loop->first ? 'text-left' : 'text-center') }}{{ false ? 'text-primary-500' : '' }}">{{ $item->getLabel() }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>
