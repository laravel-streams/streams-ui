<!-- views.blade.php -->
@if ($table->views->isNotEmpty())
<nav class="m-8">
    @foreach ($table->views as $view)
        
        <a {!! $view->htmlAttributes([
            'class' => 'py-1 px-3 rounded-sm text-sm font-bold text-black border-2 border-black inline-block',
        ]) !!}>{{ __($view->text) }}
        
            @if ($view->label)
            <span class="{{ $view->context }}">
                {{ $view->label }}
            </span>
            @endif
        </a>
    @endforeach
</nav>
@endif
