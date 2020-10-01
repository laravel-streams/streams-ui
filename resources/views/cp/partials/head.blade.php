<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
{{-- <title>{{ config('app.name') }} | {{ $item->linkTitle ? $item->linkTitle : $item->title}}</title> --}}
<title>{{ config('app.name') }}</title>
<meta name="robots" content="noindex, follow" />
<meta name="description" content="">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta name="cf-2fa-verify" content="5491995f81e49ae">

<!-- Favicon -->
{{-- {!! favicons('public::img/favicon.png') !!} --}}

<!-- CSS -->
<link href="{{ mix('/css/theme.css') }}" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;700&display=swap" rel="stylesheet">

<link href="/vendor/anomaly/streams/ui/css/theme.css" rel="stylesheet">
{{-- {!! Assets::collection('head')->add('ui::css/theme.css')->styles() !!} --}}
