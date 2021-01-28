<?php /** @var \Streams\Ui\Form\Form $form */ ?>
<!-- form.blade.php -->
<div x-data="{}"><!-- Question: Is there a need for this wrapper? -->

    @section('form')
        {!! $form->handle !!}

    {!! $form->open([
        'x-data' => /** @lang JavaScript */"window.streams.core.app.get('form')({$form->toJson()})",
        'x-init' => 'init()'
]) !!}


    @section('layout')
    @include('ui::forms.layout')
    @show

    @section('controls')
    @include('ui::forms.controls')
    @show

    {!! $form->close() !!}
    @show

</div>
