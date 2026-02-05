<div class="w-full">
    
    <p class="text-sm font-medium text-gray-900">{{ $label }}</p>

    <div aria-hidden="true" class="mt-6">
        <div class="overflow-hidden rounded-full bg-gray-200">
            <div style="width: {{ $progress }}%" class="h-2 rounded-full bg-primary-500"></div>
        </div>
        <div class="mt-6 hidden grid-cols-5 text-sm font-medium text-gray-600 sm:grid">
            @foreach ([
                ['label' => 'Upload File', 'active' => $progress >= 20],
                ['label' => 'Match Fields', 'active' => $progress >= 40],
                ['label' => 'Preview', 'active' => $progress >= 60],
                ['label' => 'Import', 'active' => $progress >= 80],
                ['label' => 'Done', 'active' => $progress >= 100],
            ] as $item)
                <div>
                    <div class="{{ $loop->last ? 'text-right' : $loop->first ? 'text-left' : 'text-center' }}{{ $item['active'] ? 'text-primary-500' : '' }}">{{ $item['label'] }}</div>
                </div>
            @endforeach
            <div class="text-primary-500">Upload File</div>
            <div class="text-center text-primary-500">Match Fields</div>
            <div class="text-center">Preview</div>
            <div class="text-right">Import</div>
            <div class="text-right">Done</div>
        </div>
    </div>
</div>
