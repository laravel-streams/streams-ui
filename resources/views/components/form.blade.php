<div class="form__wrapper">
    <form {!! $component->htmlAttributes([
        //'action' => $component->action,
        //'method' => $component->method,
        //'enctype' => $component->enctype,
        'class' => 'form',
        'method' => 'POST',
        //'wire:submit.prevent' => 'save',
        'action' => '/streams/ui/' . $component->id . '/' . ($component->action ?: 'handle'),
        ]) !!}>

        @ui('hidden', [
            'name' => '_id',
            'value' => $component->id,
        ])

        {{ csrf_field() }}

        @if (isset($slot))
        {!! $slot !!}
        @else
        <div class="form__fields">
            @foreach ($component->fields as $field)
            @ui('field', $field)
            @endforeach
        </div>

        @if ($component->buttons)
        <div class="mt-4 flex space-x-2">
            @foreach ($component->buttons as $button)
            @ui(Arr::pull($button, 'button', 'button'), Arr::parse($button, [
                'entry' => $component->entry,
            ]))
            @endforeach
        </div>
        @endif
        @endif
    </form>
</div>
