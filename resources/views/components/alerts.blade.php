<div class="p-2 absolute bottom-0 right-0">
    @foreach ($component->alerts as $alert)
    <div class="w-80 rounded bg-green-500 text-white p-2 {{ $alert['type'] }}">
        {{ $alert['content'] }}
    </div>
    @endforeach
</div>
