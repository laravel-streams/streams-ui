@props([
    'breadcrumbs' => [],
    'subheading' => null,
    'heading' => null,
    'actions' => [],
    'headingSize' => 'text-base',
    'subheadingSize' => 'text-sm',
])

<div
    {{
        $attributes->class([
            'flex items-center gap-3 p-4 sm:px-6',
        ])
    }}
>
    @if ($heading || $subheading)
        <div class="grid flex-grow">
            @if ($heading)
                <h1
                    class="{{ $headingSize }} text-xl font-bold text-gray-950"
                >
                    {{ $heading }}
                </h1>
            @endif

            @if ($subheading)
                <p
                    class="{{ $subheadingSize }}"
                >
                    {{ $subheading }}
                </p>
            @endif
        </div>
    @endif

    @if ($actions)
    <div class="flex justify-end">
        @foreach ($actions as $action)
        @if ($action->isVisible())
        {!! $action->toHtml() !!}
        @endif
        @endforeach
    </div>
    @endif
</div>
