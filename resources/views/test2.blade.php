@extends('ui::test')

@area('header','title')
    <div>Title</div>
@endarea

@area('sidebar','title')
    <div>Sidebar Title</div>
@endarea

@section('content')

    <x-ui::alert type="success">
        Hello
    </x-ui::alert>

    <x-ui::alert type="error">
        ERRRR
    </x-ui::alert>
@endsection
