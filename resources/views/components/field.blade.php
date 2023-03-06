<div {!! $component->htmlAttributes([
    'class' => [
        'w-auto' => $component->width === 'auto',
        'w-full' => $component->width === 'full',
        'w-1/2' => $component->width === '1/2',
        'w-1/3' => $component->width === '1/3',
        'w-1/4' => $component->width === '1/4',
    ],
]) !!}>

    <label class="font-bold" for="{{ $component->id }}">
        @if ($component->label)
        {{ __($component->label) }}
        @endif

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
            @ui($component->input['type'], ...[Arr::except($component->input, ['type'])])
        </div>
    </div>
    
</div>
