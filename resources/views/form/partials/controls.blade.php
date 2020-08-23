<div class="form__controls">
    
    @if(!$form->options->get('read_only'))
    <div class="form__actions">
        {!! $form->actions->render() !!}
    </div>
    @endif

    <div class="form__buttons">
        {!! $form->buttons->render() !!}
    </div>
    
</div>
