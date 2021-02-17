{{ Assets::load('scripts', 'core::js/index.js') }}
{{ Assets::load('scripts', 'api::js/index.js') }}
{{ Assets::load('scripts', 'ui::js/index.js') }}

{!! Assets::collection('scripts')->tags() !!}

<script>

    streams.serviceProviders = window.streams.serviceProviders || [
        streams.core.StreamsServiceProvider,
        streams.ui.UiServiceProvider,
        streams.api.ApiServiceProvider,
    ];

    streams.core.app.bootstrap({
        providers: streams.serviceProviders
    }).then(app => {
        return app.boot();
    }).then(app => {
        return app.start();
    });

</script>
