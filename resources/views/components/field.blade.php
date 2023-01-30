<div class="field">

    <label for="{{ $component->id }}">
        {{ __($component->label) }}

        @if ($component->required)
            <span class="field__required">*</span>
        @endif
    </label>

    @if ($component->instructions)
    <div>
        <small><em>{!! __($component->instructions) !!}</em></small>
    </div>
    @endif

    @if ($component->description)
        <span role="tooltip" title="{{ __($component->description) }}">ℹ️</span>
    @endif

    </button>
    
    <div class="field__input">
        <div class="input --{{ $component->input['type'] }}">
            @livewire($component->input['type'], ...[Arr::except($component->input, ['type'])])
        </div>
    </div>

</div>
