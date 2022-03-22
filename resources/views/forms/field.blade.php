<!-- field.blade.php -->
<div class="c-form__field">
    <div class="c-field -{{ $field->type }}-field">

        <label>
            {{ __($field->input()->label()) }}

            @if ($field->isRequired())
                <span class="c-field__required">*</span>
            @endif
        </label>
        
        <div class="c-field__input">
            <div class="c-input -{{ $field->input['type'] }}-input">
                {!! $field->input()->map->render()->implode('') !!}
            </div>
        </div>

    </div>
</div>
