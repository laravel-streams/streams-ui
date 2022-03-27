<!-- controls.blade.php -->
<div class="c-card">
    <div class="c-card__content">
        <div class="c-form__controls">
            @if(!$form->options->get('read_only'))
            <nav>
                {!! $form->actions->map->render()->implode('') !!}
            </nav>
            @endif
        
            <nav>
                {!! $form->buttons->map->render()->implode('') !!}
            </nav>    
        </div>    
    </div>    
</div>
