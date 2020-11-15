<!-- form.blade.php -->
<div x-data="{}"><!-- Question: Is there a need for this wrapper? -->

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
