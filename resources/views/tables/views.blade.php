<!-- views.blade.php -->
@if ($table->views->isNotEmpty())
<nav class="m-8">
    @foreach ($table->views as $view)
        
        <a {!! $view->htmlAttributes([
            'class' => 'py-1 px-3 text-sm font-bold text-black dark:text-white border-2 border-primary inline-block',
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
