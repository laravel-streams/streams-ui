<!-- views.blade.php -->
@if ($table->views->isNotEmpty())
<nav class="px-8">
    @foreach ($table->views as $view)
        
        <a {!! $view->htmlAttributes([
            'classes' => []
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
