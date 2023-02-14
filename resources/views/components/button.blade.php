<div>
    <{{ $component->tag }} {!! $component->htmlAttributes([
        'href' => $component->url,
        'name' => $component->name,
        'type' => $component->type,
        'disabled' => $component->disabled,
        'class' => ['px-4 py-2 border border-black rounded' => true],
    ]) !!}>
        @if (isset($slot))
            {!! $slot !!}
        @else
            {{ __($component->text) }}
        @endif
    </{{ $component->tag }}>
</div>
