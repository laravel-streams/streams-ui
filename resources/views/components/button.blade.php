<div>
    <{{ $component->tag }} ui:click.prevent="test" {!! $component->attributes(
        array_filter([
            'id' => $component->id,
            'name' => $component->name,
            'type' => $component->type,
            'disabled' => $component->disabled,
            ($component->tag == 'button' ? 'url' : 'href') => $component->url,
        ])
    ) !!}>{{ __($component->text) }}{{-- Icon --}}</{{ $component->tag }}>
</div>
