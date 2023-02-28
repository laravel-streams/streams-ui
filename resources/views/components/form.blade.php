<div class="form__wrapper">
    <form {!! $component->htmlAttributes([
        'action' => $component->action,
        'method' => $component->method,
        'enctype' => $component->enctype,
        'class' => 'form',
        ]) !!}>

        <input type="hidden" name="_id" value="{{ $component->id }}" />

        {{ csrf_field() }}

        @if (isset($slot))
        {!! $slot !!}
        @else
        <div class="form__fields">
            @foreach ($component->fields as $field)
            @livewire('field', $field)
            @endforeach
        </div>

        @if ($component->buttons)
        <div class="mt-4">
            @foreach ($component->buttons as $button)
            @livewire('button', $button)
            @endforeach
        </div>
        @endif
        @endif
    </form>
</div>
