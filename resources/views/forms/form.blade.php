<!-- form.blade.php -->
<div class="c-form" x-data="{}">
    
    {!! $form->open([
        //'x-data' => "app.get('form')({$form->toJson()})",
        //'x-init' => 'init()'
    ]) !!}

    @include('ui::forms.layout')
    @include('ui::forms.controls')
    
    {!! $form->close() !!}

</div>
