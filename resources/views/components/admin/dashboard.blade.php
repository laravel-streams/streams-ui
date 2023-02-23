<div>

    @livewire('collapsable', [
        'text' => 'Toggle Content',
        'content' => [
            [
                'component' => 'anchor',
                'url' => url('/admin'),
                'text' => 'Dashboard',
            ]
        ]
    ])

</div>
