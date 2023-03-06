@foreach ($component->{$content ?? 'content'} as $item)
@ui(Arr::pull($item, 'component'), $item)
@endforeach
