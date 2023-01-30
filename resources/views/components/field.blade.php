<div class="field --{{ $field->name }}">

    <label>
        {{ __($field->label) }}

        @if ($field->required)
            <span class="field__required">*</span>
        @endif
    </label>

    @if ($field->instructions)
    <div>
        <small><em>{!! __($field->instructions) !!}</em></small>
    </div>
    @endif
    
    <div class="field__input">
        <div class="input --{{ $field->input['type'] }}">
            @livewire($field->input['type'], ...[Arr::except($field->input, ['type'])])
        </div>
    </div>

</div>
