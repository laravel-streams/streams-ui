{{-- /var/www/development/Trabajo/GroupVitals/groupvitals.app.backend/vendor/streams/ui/resources/views/builders/action-card.blade.php --}}
<div {!! $card
    ->getHtmlAttributeBag()
    ->class([$card->attributes['class'] ?? 'bg-white p-8 rounded-2xl border border-gray-200 shadow-sm'])
!!}>

    <div class="flex flex-col items-center text-center">

        <div class="w-20 h-20 rounded-md flex items-center justify-center mb-6 bg-blue-50 text-blue-600">
            @php
                $iconName = $card->getIcon();
            @endphp

            {{-- Usamos una directiva de Blade para renderizar el icono solo si es un string --}}
            @if (is_string($iconName) && !empty($iconName))
                @svg($iconName, 'w-10 h-10')
            @else
                {{-- SVG manual para que no dependa de ninguna función externa y no rompa --}}
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3 3m0 0l-3-3m3 3V10"></path>
                </svg>
            @endif
        </div>

        <h3 class="text-xl font-bold mb-2 text-gray-900">
            {{ $card->getLabel() }}
        </h3>

        <p class="text-gray-500 text-sm mb-6 max-w-[250px]">
            {{ $card->getDescription() }}
        </p>
        {!! $card->getAction()?->render() ?? '' !!}
    </div>
</div>
