@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $previewUrl = $getPreviewUrl();
    $fileName = $getCurrentFileName();
    $showImagePreview = $shouldShowImagePreview();
    $accept = $getAccept();
    $multiple = $isMultiple();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" class="flex">
    <div class="grid w-full gap-y-3">
        @if ($showImagePreview && filled($previewUrl))
            <div class="flex items-center gap-3">
                <img
                    src="{{ $previewUrl }}"
                    alt="{{ $fileName ?? '' }}"
                    class="h-16 w-16 shrink-0 rounded-xl object-cover ring-1 ring-black/5"
                />
                @if (filled($fileName))
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $fileName }}</p>
                        <p class="text-xs text-gray-500">Current file — choose a new one to replace</p>
                    </div>
                @endif
            </div>
        @elseif (filled($fileName))
            <div class="rounded-xl bg-gray-50 px-3 py-2 ring-1 ring-gray-200">
                <p class="text-sm text-gray-700">
                    <span class="font-medium text-gray-900">Current:</span>
                    <span class="truncate">{{ $fileName }}</span>
                </p>
                <p class="text-xs text-gray-500">Choose a new file to replace</p>
            </div>
        @endif

        <x-ui::inputs.file
            :attributes="new \Illuminate\View\ComponentAttributeBag([
                'disabled' => $isDisabled,
                'id' => $id,
                'readonly' => $isReadonly(),
                'required' => $isRequired(),
                'accept' => $accept,
                'multiple' => $multiple,
                'wire:model' => $statePath,
            ])->merge($getHtmlAttributes())"
        />
    </div>
</x-dynamic-component>
