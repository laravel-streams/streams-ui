@if ($form->options->hasAny(['title', 'description']))
<div>

    @if ($form->options->has('title'))
    <div>
        {{ $form->options->get('title') }}
    </div>
    @endif

    @if ($form->options->has('description'))
    <div>
        {{ $form->options->get('description') }}
    </div>
    @endif

</div>
@endif
