@foreach ($component->{$name ?? 'components'} as $item)
@livewire(Arr::pull($item, 'component'), $item)
@endforeach
