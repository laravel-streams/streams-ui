{{-- {!! Assets::tag('/vendor/streams/core/js/index.js') !!}
{!! Assets::tag('/vendor/streams/api/js/index.js') !!} --}}
{{-- {!! Assets::tag('/vendor/streams/ui/js/index.js') !!} --}}

{!! Assets::collection('scripts')->tags() !!}

<script>

    // streams.serviceProviders = window.streams.serviceProviders || [
    //     streams.core.StreamsServiceProvider,
    //     streams.ui.UiServiceProvider,
    //     streams.api.ApiServiceProvider,
    // ];

    // streams.core.app.bootstrap({
    //     providers: streams.serviceProviders
    // }).then(app => {
    //     return app.boot();
    // }).then(app => {
    //     return app.start();
    // });

</script>

{{-- Optional live-update helpers. Guarded: no-ops when Echo or Alpine are absent. --}}
<script>
{!! file_get_contents(__DIR__.'/../../../js/refresh-on.js') !!}
{!! file_get_contents(__DIR__.'/../../../js/log-tail.js') !!}
</script>

{!! Includes::render('assets') !!}
