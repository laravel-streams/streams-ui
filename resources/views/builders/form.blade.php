<form
    {!! $attributes
        ->merge($getHtmlAttributes())
        ->merge([
            'x-data' => '{ isUploadingFile: false }',
            'x-on:submit' => 'if (isUploadingFile) $event.preventDefault()',
            'x-on:file-upload-started' => 'isUploadingFile = true',
            'x-on:file-upload-finished' => 'isUploadingFile = false',
        ])
        ->class(['ui-form grid gap-y-6']) !!}>


    <div class="flexf flex-col space-y-4">
        @foreach ($getComponents(true) as $component)
        @php
        // $isHidden = $component->isHidden();
        $isHidden = false;
        @endphp

            @if (!$isHidden)
            {{ $component }}
            @endif
            
        @endforeach

        <div class="flex">
            @foreach ($form->getActions() as $action)
            {!! $action->render() !!}
            @endforeach
        </div>
    </div>

</form>
