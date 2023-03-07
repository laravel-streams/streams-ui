<div class="form__wrapper">
    <form {!! $component->htmlAttributes([
        //'action' => $component->action,
        //'method' => $component->method,
        //'enctype' => $component->enctype,
        'class' => 'form',
        ]) !!} wire:submit.prevent="save">

        @ui('hidden', [
            'name' => '__id',
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
        <div class="mt-4">
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
