{{-- 
    Keep this partial around for isolation.
    Move configuration out of this
    file towards the ridges.
--}}

<!-- @todo prefix with cp? like cp.scripts -->
{{ Assets::load('scripts', 'core::js/index.js') }}
{{ Assets::load('scripts', 'api::js/index.js') }}
{{ Assets::load('scripts', 'ui::js/index.js') }}

{!! Assets::collection('scripts')->tags() !!}

{{--<script src="/vendor/streams/core/js/core.js"></script>--}}
{{--<script src="/vendor/streams/ui/js/ui.js"></script>--}}

<script>
streams.serviceProviders = window.streams.serviceProviders || [];
streams.core.app.bootstrap({
    providers: [
        streams.core.StreamsServiceProvider,
        streams.ui.UiServiceProvider,
        streams.api.ApiServiceProvider,
    ]
}).then(app => {
    return app.boot();
}).then(app => {
    return app.start();
});
</script>

<script>
    // On page load or when changing themes, best to add inline in `head` to avoid FOUC
    if ( localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) ) {
        document.querySelector('html').classList.add('dark');
    } else {
        document.querySelector('html').classList.remove('dark');
    }
</script>
