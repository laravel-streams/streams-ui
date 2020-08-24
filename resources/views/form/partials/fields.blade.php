@foreach ($fields as $field)
<div id="{{ $form->prefix('field-' . $field->slug) }}" class="form__fieldset">
    {!! $field->type()->field !!}: {!! $field->type()->value !!}
</div>
@endforeach
