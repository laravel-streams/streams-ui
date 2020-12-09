<div class="flex h-16 overflow-y-auto border-b-2 border-primary">
    <div class="flex items-center px-4">
        <a class="logo-link font-mono text-2xl">
            @if ($theme = Streams::entries('theme')->find('settings'))
            {{ $theme->name ?: __(config('app.name')) }}
            @else
            {{ __(config('app.name')) }}
            @endif
        </a>
    </div>
</div>
