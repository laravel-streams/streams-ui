<!-- views.blade.php -->
@if ($table->views->isNotEmpty())
<nav class="c-table__views">
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
