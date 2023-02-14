<div>
    @livewire('table', [
        'columns' => [
            [
                'heading' => 'ID',
                'value' => 'id',
            ],
        ],
        'buttons' => [
            [
                'tag' => 'a',
                'text' => 'Edit',
                'url' => '/{request.segments.0}/{request.segments.1}/edit/{entry.id}',
            ],
        ],
    ])
</div>
