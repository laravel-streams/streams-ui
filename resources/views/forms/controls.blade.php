<!-- controls.blade.php -->
<div class="border-t-2 border-primary mt-8 py-4 px-8 flex justify-end">
    
    @if(!$form->options->get('read_only'))
    <nav class="flex-1">
        {!! $form->actions->render() !!}
    </nav>
    @endif

    <nav>
        {!! $form->buttons->render() !!}
    </nav>
    
</div>
