<div>
    <{{ $component->tag }} {!! $component->htmlAttributes([
        'href' => $component->url(),
        'name' => $component->name,
        'type' => $component->type,
        'disabled' => $component->disabled,
        'class' => [
            'btn',
            'btn-' . $component->size,
            'btn-' . $component->color,
            'btn-outline' => $component->outline,
        ],
    ]) !!}>
        @if (isset($slot))
            {!! $slot !!}
        @else
            {{ __($component->text) }}
        @endif
    </{{ $component->tag }}>
</div>
