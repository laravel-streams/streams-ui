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
                'text' => 'Edit',
                'url' => '/{request.segments.1}/{request.segments.2}/edit',
            ],
        ],
    ])
</div>
