@foreach ($component->{$name ?? 'components'} as $item)
@ui(Arr::pull($item, 'component'), $item)
@endforeach
