@extends('ui::test')

@area('header','title')
    <div>Title</div>
@endarea

@area('sidebar','title')
    <div>Sidebar Title</div>
@endarea

@section('content')

    <x-ui::alert type="success">
        The information has been stored
    </x-ui::alert>

    <x-ui::alert type="info">
        The information has been stored
    </x-ui::alert>

    <x-ui::alert type="warning">
        Could not find the thing you are looking for
    </x-ui::alert>

    <x-ui::alert type="error">
        Something went wrong
    </x-ui::alert>


    <x-ui::alert type="success" label="Information Stored">
        The information has been stored
    </x-ui::alert>

    <x-ui::alert type="info"  label="Information Stored">
        The information has been stored
    </x-ui::alert>

    <x-ui::alert type="warning" label="Not Found">
        Could not find the thing you are looking for
    </x-ui::alert>

    <x-ui::alert type="error" label="Error">
        Something went wrong
    </x-ui::alert>


@endsection
