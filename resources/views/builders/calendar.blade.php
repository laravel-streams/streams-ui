@once
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
@endonce

@php
    $calendarId = $calendar->getId();
    $config = $calendar->getConfig();
@endphp

<div {{ $attributes->merge($calendar->getHtmlAttributes())->class([
    'flex flex-col',
]) }}>
    @if ($calendar->getHeading() || $calendar->getDescription() || $calendar->getActions())
        <div class="mb-4 flex items-center justify-between heading">
            <div class="flex flex-col">
                @if ($heading = $calendar->getHeading())
                    @if ($url = $calendar->getUrl())
                        <h2 class="font-semibold">
                            <a href="{{ $url }}" class="text-xl underline" @if ($calendar->shouldOpenInNewTab()) target="_blank" rel="noopener noreferrer" @endif>{!! __($heading) !!}</a>
                        </h2>
                    @else
                        <h2 class="text-xl font-semibold">{!! __($heading) !!}</h2>
                    @endif
                @endif

                @if ($description = $calendar->getDescription())
                    <p>{{ __($description) }}</p>
                @endif
            </div>

            @if ($actions = $calendar->getActions())
                <div class="flex items-center space-x-2">
                    @foreach ($actions as $action)
                        {!! $action->render() !!}
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <div class="overflow-hidden rounded-lg border border-gray-200 bg-white p-4 shadow-sm">
        <div id="{{ $calendarId }}" wire:ignore></div>
    </div>

    <script>
        (() => {
            const calendarId = @js($calendarId);
            const config = @js($config);

            const initCalendar = () => {
                if (typeof FullCalendar === 'undefined') {
                    window.requestAnimationFrame(initCalendar);
                    return;
                }

                const element = document.getElementById(calendarId);

                if (!element || element.dataset.calendarInitialized === 'true') {
                    return;
                }

                element.dataset.calendarInitialized = 'true';

                const calendar = new FullCalendar.Calendar(element, config);

                calendar.render();
            };

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCalendar, { once: true });
                return;
            }

            initCalendar();
        })();
    </script>
</div>
