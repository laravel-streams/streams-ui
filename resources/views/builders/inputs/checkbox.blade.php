@props([
    'valid' => true,
    'label' => null,
])

<label for="{{ $field->getId() }}" class="inline-flex items-center space-x-2 cursor-pointer" {{ $field->getHtmlAttributeBag() }}>
    <input type="checkbox" name="{{ $field->getName() }}" x-ref="{{ $field->getId() }}" id="{{ $field->getId() }}" wire:model="{{ $field->getStatePath() }}"
        {{
            $attributes
                ->class([
                    'rounded border-none bg-white shadow-sm ring-1 transition duration-75 checked:ring-0 focus:ring-2 focus:ring-offset-0 disabled:pointer-events-none disabled:bg-gray-50 disabled:text-gray-50 disabled:checked:bg-current disabled:checked:text-gray-400',
                ])
        }}
    />

    <span class="text-sm font-medium text-gray-700">
        {{ $field->getLabel() }}
    </span>

</label>
