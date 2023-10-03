@extends('ui::layouts/blank')

@section('content')
    <div class="flex">

        <div 
            class="w-1/2 h-screen bg-repeat"
            style="background-size: 100%; background-image: {{ Images::make('ui::img/bg-pattern.jpg')->css() }}">
        </div>
        
        <div class="w-1/2 flex flex-col items-center justify-center">

            {!! Images::make('ui::img/logo.png')->width(100) !!}
            
            @ui('admin.login')
            
        </div>

    </div>
@endsection
