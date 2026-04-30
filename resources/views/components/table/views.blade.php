@props([
    'views' => [],
    'tableName' => 'default',
    'active' => null,
])

@if ($views)
<div {{ $attributes->class(['flex items-center gap-2']) }}>
    @foreach ($views as $view)
        <button
            type="button"
            wire:click="applyTableView('{{ $view->getName() }}', '{{ $tableName }}')"
            @disabled($view->isDisabled())
            class="@class([
                'px-2.5 py-1.5 text-xs font-medium rounded-md border transition',
                'border-primary-500 bg-primary-50 text-primary-700' => $active === $view->getName(),
                'border-gray-300 text-gray-600 hover:text-gray-800 hover:border-gray-400' => $active !== $view->getName(),
                'opacity-50 cursor-not-allowed' => $view->isDisabled(),
            ])"
        >
            {{ $view->getLabel() }}
        </button>
    @endforeach
</div>
@endif
