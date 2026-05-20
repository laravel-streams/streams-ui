@php
    $icon = $modalHeader->getIcon();
@endphp

<div {{ $modalHeader->getHtmlAttributeBag()->class('ui-modal-header flex items-start justify-between gap-4 px-6 pt-6') }}>
    <div class="flex items-start gap-3">
        @if (filled($icon))
            <x-ui::icon
                :attributes="
                    new \Illuminate\View\ComponentAttributeBag([
                        'icon' => $icon,
                        'class' => 'h-6 w-6 text-gray-600',
                    ])"
            />
        @endif

        <div>
            @if ($title = $modalHeader->getTitle())
                <h2 class="text-2xl font-semibold leading-6 text-gray-950">
                    {{ $title }}
                </h2>
            @endif

            @if ($description = $modalHeader->getDescription())
                <p class="mt-2 text-gray-500 dark:text-gray-400">
                    {{ $description }}
                </p>
            @endif
        </div>
    </div>

    @if ($actions = $modalHeader->getActions())
        <div class="flex items-center gap-2">
            @foreach ($actions as $action)
                @if ($action->isVisible())
                    {!! $action->render() !!}
                @endif
            @endforeach
        </div>
    @endif
</div>
