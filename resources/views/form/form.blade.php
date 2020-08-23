<cp-form :form="{{ $form->toJson() }}"></cp-form>

@section('content')
    <div class="form__wrapper">

        {!! $form->open() !!}
        @include('ui::form/partials/heading')
        @include('ui::form/partials/layout')
        @include('ui::form/partials/controls')
        {!! $form->close() !!}

    </div>
@endsection
