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
                'url' => '/{request.segments.0}/{request.segments.1}/{entry.id}/edit',
            ],
        ],
    ])
</div>
