<div>
    <span class="rounded-full bg-black text-sm text-white px-2 {{ $this->text ? 'py-1' : '' }}">
        {{ $slot ?? $this->text }}
    </span>
</div>
