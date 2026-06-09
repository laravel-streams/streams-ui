@php
    $align = $prompt->getAlign() ?? 'left';
    $size = $prompt->getSize() ?? 'md';
    $text = $prompt->getText();
    $actions = array_values(array_filter(
        $prompt->getActions(),
        fn ($action) => $action->isVisible(),
    ));
    $actionCount = count($actions);

    $wrapperClasses = Arr::toCssClasses([
        'inline-flex flex-wrap items-baseline gap-x-1 w-full',
        match ($align) {
            'center' => 'justify-center text-center',
            'right' => 'justify-end text-right',
            default => 'justify-start text-left',
        },
        match ($size) {
            'sm' => 'text-sm',
            default => 'text-base',
        },
    ]);
@endphp

<div {!! $prompt->getHtmlAttributeBag()->class([$wrapperClasses]) !!}>
    @if (filled($text))
        <span @class(['text-gray-500' => $prompt->isMuted()])>{{ $text }}</span>
    @endif

    @foreach ($actions as $index => $action)
        @if ($actionCount > 1 && $index === $actionCount - 1)
            <span>&nbsp;and&nbsp;</span>
        @elseif ($index > 0)
            <span>&nbsp;</span>
        @endif

        {!! $action->render() !!}
    @endforeach
</div>
