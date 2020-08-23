@if ($table->options->hasAny(['title', 'description']))
<div>

    @if ($table->options->has('title'))
    <div>
        {{ $table->options->get('title') }}
    </div>
    @endif

    @if ($table->options->has('description'))
    <div>
        {{ $table->options->get('description') }}
    </div>
    @endif

</div>
@endif
