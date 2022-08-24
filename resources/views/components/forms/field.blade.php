<div class="c-form__field">
    <div class="c-field -{{ $field->handle }}-field">

        <label>
            {{ __($field->input()->label()) }}

            @if ($field->isRequired())
                <span class="c-field__required">*</span>
            @endif
        </label>

        @if ($field->input()->instructions)
        <p class="mb-4 text-sm italic">{!! __($field->input()->instructions) !!}</p>
        @endif
        
        <div class="c-field__input">
            <div class="c-input -{{ Arr::get($field->input, 'type', 'input') }}-input">
                {!! $field->input()->render() !!}
            </div>
        </div>

    </div>
</div>
