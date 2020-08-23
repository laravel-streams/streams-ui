@if ($table->views->isNotEmpty())
<div>
    <nav>
        @foreach ($table->views as $view)
            {{-- <a {!! html_attributes($view->attributes()) !!}> --}}
            <a>
                {{-- {!! $view->icon() !!} --}}
                {{ $view->text }}

                @if ($view->label)
                <span class="{{ $view->context }}">
                    {{ $view->label }}
                </span>
                @endif
            </a>
        @endforeach
    </nav>
</div>
@endif
