<div {{ $attributes->class(['flex flex-col space-y-4']) }}>
    @if ($heading = $display->getHeading())
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-semibold">{{ __($heading) }}</h2>
        @foreach ($display->getActions() as $action)
            @if ($action->isVisible()){!! $action->render() !!}@endif
        @endforeach
    </div>
    @endif
    <dl class="grid grid-cols-1 gap-4">
        @foreach ($display->getEntries() as $entry)
        <div>
            <dt class="text-sm text-gray-500">{{ $entry->getLabel() }}</dt>
            <dd>{{ is_scalar($entry->getState()) ? $entry->getState() : json_encode($entry->getState()) }}</dd>
        </div>
        @endforeach
    </dl>
</div>
