@foreach ($fields as $field)
<div id="{{ $form->prefix('field-' . $field->slug) }}" class="form__fieldset">
    @include('ui::forms.field', ['field' => $field])
</div>
@endforeach
