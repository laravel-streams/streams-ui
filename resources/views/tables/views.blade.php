<!-- views.blade.php -->
@if ($table->views->isNotEmpty())
<nav class="ls-table__views m-8">
    @foreach ($table->views as $view)
        
        <a {!! $view->htmlAttributes() !!}>
            {{ __($view->text) }}
            @if ($view->label)
            <span>
                {{ $view->label }}
            </span>
            @endif
        </a>
    @endforeach
</nav>
@endif
