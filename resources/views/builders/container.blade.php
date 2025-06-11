<div {{ $attributes->class([
    'flex flex-col space-y-6 p-6',
]) }}>
    @foreach ($container->getComponents() as $component)
    {{ $component }}
    @endforeach
</div>
