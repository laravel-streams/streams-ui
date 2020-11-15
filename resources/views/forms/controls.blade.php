<!-- controls.blade.php -->
<div class="border-t border-gray-400 mt-8 p-8  flex justify-end -mx-1">
    
    @if(!$form->options->get('read_only'))
    <div class=" mx-1">
        {!! $form->actions->render() !!}
    </div>
    @endif

    <div class="">
        {!! $form->buttons->render() !!}
    </div>
    
</div>
