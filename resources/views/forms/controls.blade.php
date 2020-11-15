<!-- controls.blade.php -->
<div class="flex justify-end -mx-1">
    
    @if(!$form->options->get('read_only'))
    <div class=" mx-1">
        {!! $form->actions->render() !!}
    </div>
    @endif

    <div class="">
        {!! $form->buttons->render() !!}
    </div>
    
</div>
