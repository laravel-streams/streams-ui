<div class="form__layout">
    @if ($form->fields->isEmpty())
        {{ trans("ui::message.no_fields_available") }}
    @else
        @if ($form->sections->isnotEmpty())
            @foreach ($form->sections as $section)
                @if (isset($section['view']))
                    @include($section['view'])
                @elseif (isset($section['html']))
                    {!! $section['html'] !!}
                @elseif (isset($section['tabs']))
                    @include('ui::form/partials/tabs')
                @else
                    @include('ui::form/partials/section')
                @endif
            @endforeach
        @else
            @include('ui::form/partials/default')
        @endif
        
    @endif
</div>
