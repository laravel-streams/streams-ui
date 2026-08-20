@php
    $id = $getId();
    $isDisabled = $isDisabled();
    $statePath = $getStatePath();
    $previewUrl = $getPreviewUrl();
    $fileName = $getCurrentFileName();
    $showImagePreview = $shouldShowImagePreview();
    $canRemove = $canRemoveCurrentFile();
    $accept = $getAccept();
    $multiple = $isMultiple();
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field" class="flex">
    <div class="grid w-full gap-y-3">
        @if ($showImagePreview && filled($previewUrl))
            <div class="flex items-center gap-3 px-3">
                <img
                    src="{{ $previewUrl }}"
                    alt="{{ $fileName ?? '' }}"
                    class="h-16 w-16 shrink-0 rounded-md object-cover ring-1 ring-black/5"
                />
                @if (filled($fileName))
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $fileName }}</p>
                        <p class="text-xs text-gray-500">Current file — choose a new one to replace</p>
                    </div>
                @endif
                @if ($canRemove)
                    <button
                        type="button"
                        wire:click="$set('{{ $statePath }}', null)"
                        class="shrink-0 text-sm font-medium text-gray-600 hover:text-gray-900"
                    >
                        Remove
                    </button>
                @endif
            </div>
        @elseif (filled($fileName))
            <div class="flex items-center gap-3 rounded-md bg-gray-50 px-3 py-2 ring-1 ring-gray-200">
                <div class="min-w-0 flex-1">
                    <p class="text-sm text-gray-700">
                        <span class="font-medium text-gray-900">Current:</span>
                        <span class="truncate">{{ $fileName }}</span>
                    </p>
                    <p class="text-xs text-gray-500">Choose a new file to replace</p>
                </div>
                @if ($canRemove)
                    <button
                        type="button"
                        wire:click="$set('{{ $statePath }}', null)"
                        class="shrink-0 text-sm font-medium text-gray-600 hover:text-gray-900"
                    >
                        Remove
                    </button>
                @endif
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
