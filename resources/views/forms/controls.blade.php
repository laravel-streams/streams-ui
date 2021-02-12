<!-- controls.blade.php -->
<div class="c-card">
    <div class="c-card__content">
        <div class="c-form__controls">
            @if(!$form->options->get('read_only'))
            <nav>
                {!! $form->actions->render() !!}
            </nav>
            @endif
        
            <nav>
                {!! $form->buttons->render() !!}
            </nav>    
        </div>    
    </div>    
</div>
