<meta name="csrf_token" value="{{ csrf_token() }}"/>

<script type="text/javascript">
    const APP_DEBUG = "{{ config('app.debug') }}";
    const APP_URL = "{{ config('app.url') }}";
    const APP_ENV = "{{ app()->environment() }}";
    const REQUEST_ROOT = "{{ request()->root() }}";
    const REQUEST_ROOT_PATH = "{{ \Illuminate\Support\Arr::get(parse_url(request()->root()), 'path') }}";
    const CSRF_TOKEN = "{{ csrf_token() }}";
    const TIMEZONE = "{{ config('app.timezone') }}";
    const LOCALE = "{{ config('app.locale') }}";
</script>
