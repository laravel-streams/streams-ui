<div class="form__layout">
    @if ($form->sections->isnotEmpty())
        @foreach ($form->sections as $section)
            @if (isset($section['view']))
                @include($section['view'])
            @elseif (isset($section['html']))
                {!! View::parse($section['html']) !!}
            @elseif (isset($section['tabs']))
                @include('ui::forms.tabs')
            @else
                @include('ui::forms.section')
            @endif
        @endforeach
    @else
        @include('ui::forms.default')
    @endif
</div>
