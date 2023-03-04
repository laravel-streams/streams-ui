<div>

    <div>
        @ui('breadcrumbs')
    </div>

    @if (Request::segment(4))
        @ui('form', [
            'stream' => Request::segment(2),
            'entry' => Request::segment(3),
        ])
    @elseif (Request::segment(3))
        @ui('form', [
            'stream' => Request::segment(2),
        ])
    @elseif (Request::segment(2))
        @ui('table', [
            'stream' => Request::segment(2),
            'pagination' => [
                'per_page' => Request::get('per_page', 15),
            ],
        ])
    @else
        Unknown
    @endif
</div>
