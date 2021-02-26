<!-- form.blade.php -->
<div class="c-form" x-data="{}">
    
    @section('form')
    {!! $form->open([
        //'x-data' => "app.get('form')({$form->toJson()})",
        //'x-init' => 'init()'
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
