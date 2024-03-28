<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ $metaTitle ?? config('app.name') }}</title>

{{-- {!! favicons('public::img/favicon.png') !!} --}}
<link rel="icon" type="image/png" href="/vendor/streams/ui/img/favicon.png"/>

{!! Assets::collection('scripts.head')->tags() !!}

<!-- styles.blade.php -->
{{-- {{ Assets::load('styles', 'vendor/streams/ui/css/variables.css') }}
{{ Assets::load('styles', 'vendor/streams/ui/css/theme.css') }} --}}

{!! Assets::collection('styles')->tags() !!}

<style>
    :root {
        @foreach ($cssVariables ?? [] as $cssVariableName => $cssVariableValue) --{{ $cssVariableName }}:{{ $cssVariableValue }}; @endforeach
    }
</style>

@include('ui::support.constants')
