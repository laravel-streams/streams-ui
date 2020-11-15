<div class="" x-data="{}">

    @section('form')
    {!! $form->open() !!}

    @section('layout')
    @include('ui::forms.layout')
    @show

    @section('controls')
    @include('ui::forms.controls')
    @show

    {!! $form->close() !!}
    @show

</div>
