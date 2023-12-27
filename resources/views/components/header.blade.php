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
        <div class="grid gap-y-1 flex-grow">
            @if ($heading)
                <h1
                    class="{{ $headingSize }} font-bold text-gray-950"
                >
                    {{ $heading }}
                </h1>
            @endif

            @if ($subheading)
                <p
                    class="{{ $subheadingSize }} text-gray-600"
                >
                    {{ $subheading }}
                </p>
            @endif
        </div>
    @endif

    @if ($actions)
    <div class="flex justify-end">
        @foreach ($actions as $action)
            {!! $action->toHtml() !!}
        @endforeach
    </div>
    @endif
</div>
