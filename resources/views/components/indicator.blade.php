<div>
    <span class="rounded-full bg-black text-sm text-white px-2 {{ $component->text ? 'py-1' : '' }}">
        {{ $slot ?? $component->text }}
    </span>
</div>
