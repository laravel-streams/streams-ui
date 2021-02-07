<?php /** @var \Streams\Ui\Form\Form $form */ ?>
<!-- form.blade.php -->
<div x-data="{}" class="ls-form">
    <!--
        Question: Is there a need for this wrapper?
        Less is more, but nothing often leads to needing *something*.
        So, a thin sushi-like wrapper. Yes?
     -->

    @section('form')
    {!! $form->open([
        'x-data' => "app.get('form')({$form->toJson()})",
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
