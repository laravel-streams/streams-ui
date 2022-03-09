@extends('ui::test')

@push('topbar')
    <div>asdfsadf</div>
@endpush

@push('sidebar')
    <div>Fooo</div>
@endpush

@section('content')

    <x-ui::alert type="success">
        Hello
    </x-ui::alert>

    <x-ui::alert type="error">
        ERRRR
    </x-ui::alert>
@endsection
