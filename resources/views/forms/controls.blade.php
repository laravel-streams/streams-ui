<!-- controls.blade.php -->
<div class="ls-form__controls">
    
    @if(!$form->options->get('read_only'))
    <nav>
        {!! $form->actions->render() !!}
    </nav>
    @endif

    <nav>
        {!! $form->buttons->render() !!}
    </nav>
    
</div>
