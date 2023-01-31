<form wire:submit.prevent="submit">
    @if (isset($slot))
        {!! $slot !!}
    @else
        @livewire('fields', ['fields' => $component->fields])
    @endif

    @livewire('buttons', [
        'buttons' => [
            [
                'type' => 'submit',
                'text' => 'Submit',
                'disabled' => false,
            ],
            [
                'tag' => 'a',
                'text' => 'Cancel',
                'url' => '/ui',
            ]
        ]
    ])

</form>
