<section>
    
    <div class="form__container">

        {!! $form->open() !!}
        @include('ui::form/partials/heading')
        @include('ui::form/partials/layout')
        @include('ui::form/partials/controls')
        {!! $form->close() !!}

    </div>

</section>
