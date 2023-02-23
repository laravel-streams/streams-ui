@foreach ($component->{$content ?? 'content'} as $item)
@livewire(Arr::pull($item, 'component'), $item)
@endforeach
