<div {!! $component->htmlAttributes() !!}>

    <label class="font-bold" for="{{ $component->id }}">
        {{ __($component->label) }}

        @if ($component->required)
            <span class="field__required">*</span>
        @endif
    </label>

    @if ($component->description)
        <span role="tooltip" class="cursor-help" title="{{ __($component->description) }}">ℹ️</span>
    @endif

    @if ($component->instructions)
    <div>
        <small><em>{!! __($component->instructions) !!}</em></small>
    </div>
    @endif
    
    <div class="field__input">
        <div class="input --{{ $component->input['type'] }}">
            @livewire($component->input['type'], ...[Arr::except($component->input, ['type'])])
        </div>
    </div>
    
</div>
