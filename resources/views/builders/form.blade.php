@php
    $isRow = ! $form->isColumnDirection();
@endphp
<form
    {!! $attributes
        ->merge($getHtmlAttributes())
        ->merge([
            'x-data' => '{ isUploadingFile: false }',
            'x-on:submit' => 'if (isUploadingFile) $event.preventDefault()',
            'x-on:file-upload-started' => 'isUploadingFile = true',
            'x-on:file-upload-finished' => 'isUploadingFile = false',
        ])
        ->class([
            'ui-form',
            'grid gap-y-6' => ! $isRow,
            'flex min-w-0 flex-1 items-center gap-2' => $isRow,
        ]) !!}>


    <div @class([
        'flex',
        'flex-col space-y-4' => ! $isRow,
        'min-w-0 flex-1 flex-row items-center gap-2' => $isRow,
    ])>
        @foreach ($getComponents(true) as $component)
        @php
        // $isHidden = $component->isHidden();
        $isHidden = false;
        @endphp

            @if (!$isHidden)
            <div @class(['min-w-0 flex-1' => $isRow])>
                {{ $component }}
            </div>
            @endif
            
        @endforeach

        @if ($form->getActions())
            <div @class([
                'flex shrink-0 items-center gap-2',
                'flex' => ! $isRow,
            ])>
                @foreach ($form->getActions() as $action)
                {!! $action->render() !!}
                @endforeach
            </div>
        @endif
    </div>

</form>
