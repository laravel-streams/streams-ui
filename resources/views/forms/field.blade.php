<!-- field.blade.php -->
<div class="ls-field --{{ $field->type }}-field">

    <label>
        {{ __($field->input()->label()) }}

        @if ($field->isRequired())
            <span>*</span>
        @endif
    </label>
    
    <div class="ls-input --{{ $field->input['type'] }}-input">
        {!! $field->input()->render() !!}
    </div>

</div>
