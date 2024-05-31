@props(['filters'])

<div {{ $attributes->class(['grid gap-y-4']) }}>

    <div class="flex justify-between">
        <h4 class="font-semibold">
            Filters
        </h4>

        <button class="text-danger-500 font-semibold">Clear</button>
    </div>

    @foreach ($filters as $filter)
        {!! $filter->render() !!}
    @endforeach
</div>
