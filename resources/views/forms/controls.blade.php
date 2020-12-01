<!-- controls.blade.php -->
<div class="border-t-2 border-black mt-8 p-8 flex justify-end">
    
    @if(!$form->options->get('read_only'))
    <div class=" mx-1">
        {!! $form->actions->render() !!}
    </div>
    @endif

    <div class="">
        {!! $form->buttons->render() !!}
    </div>
    
</div>
