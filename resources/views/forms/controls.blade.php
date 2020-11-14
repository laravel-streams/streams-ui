<!-- controls.blade.php -->
<div class="form__controls flex justify-end -mx-1">
    
    @if(!$form->options->get('read_only'))
    <div class="form__actions mx-1">
        {!! $form->actions->render() !!}
    </div>
    @endif

    <div class="form__buttons">
        {!! $form->buttons->render() !!}
    </div>
    
</div>
